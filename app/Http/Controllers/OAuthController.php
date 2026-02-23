<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\OAuthClient;
use App\Models\OAuthAuthCode;
use App\Models\OAuthAccessToken;

class OAuthController extends Controller
{
    /**
     * Show authorize form or redirect to login if not authenticated
     */
    public function authorize(Request $request)
    {
        $request->validate([
            'client_id' => 'required|string',
            'redirect_uri' => 'required|url',
            'response_type' => 'required|in:code',
        ]);

        // Verify client
        $client = OAuthClient::where('client_id', $request->client_id)->first();

        if (!$client || $client->redirect_uri !== $request->redirect_uri) {
            return response()->json(['error' => 'Invalid client'], 400);
        }

        // Store OAuth params in session
        $request->session()->put('oauth_params', [
            'client_id' => $request->client_id,
            'redirect_uri' => $request->redirect_uri,
            'response_type' => $request->response_type,
            'state' => $request->state,
        ]);

        // If not logged in, redirect to login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('oauth.authorize', [
            'client' => $client,
            'params' => $request->session()->get('oauth_params'),
        ]);
    }

    /**
     * Show authorize form when user is already logged in
     */
    public function showAuthorizeForm(Request $request)
    {
        $params = $request->session()->get('oauth_params');

        if (!$params) {
            return redirect()->route('dashboard');
        }

        $client = OAuthClient::where('client_id', $params['client_id'])->first();

        return view('oauth.authorize', [
            'client' => $client,
            'params' => $params,
        ]);
    }

    /**
     * Handle authorization approval
     */
    public function approveAuthorize(Request $request)
    {
        $params = $request->session()->get('oauth_params');

        if (!$params) {
            return redirect()->route('dashboard');
        }

        // Generate auth code
        $code = Str::random(40);

        OAuthAuthCode::create([
            'user_id' => Auth::id(),
            'client_id' => $params['client_id'],
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Clear session
        $request->session()->forget('oauth_params');

        // Redirect back to client with auth code
        $redirectUri = $params['redirect_uri'] . '?' . http_build_query([
            'code' => $code,
            'state' => $params['state'] ?? '',
        ]);

        return redirect($redirectUri);
    }

    /**
     * Deny authorization
     */
    public function denyAuthorize(Request $request)
    {
        $params = $request->session()->get('oauth_params');
        $request->session()->forget('oauth_params');

        if ($params) {
            $redirectUri = $params['redirect_uri'] . '?' . http_build_query([
                'error' => 'access_denied',
                'state' => $params['state'] ?? '',
            ]);
            return redirect($redirectUri);
        }

        return redirect()->route('dashboard');
    }

    /**
     * Exchange auth code for access token (API endpoint)
     */
    public function token(Request $request)
    {
        $request->validate([
            'grant_type' => 'required|in:authorization_code',
            'code' => 'required|string',
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'redirect_uri' => 'required|string',
        ]);

        // Verify client
        $client = OAuthClient::where('client_id', $request->client_id)
            ->where('client_secret', $request->client_secret)
            ->first();

        if (!$client) {
            return response()->json(['error' => 'invalid_client'], 401);
        }

        // Verify auth code
        $authCode = OAuthAuthCode::where('code', $request->code)
            ->where('client_id', $request->client_id)
            ->where('expires_at', '>', now())
            ->first();

        if (!$authCode) {
            return response()->json(['error' => 'invalid_grant'], 400);
        }

        // Generate access token
        $token = Str::random(80);

        OAuthAccessToken::create([
            'user_id' => $authCode->user_id,
            'client_id' => $request->client_id,
            'token' => $token,
            'expires_at' => now()->addDays(30),
        ]);

        // Delete used auth code
        $authCode->delete();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 2592000, // 30 days
        ]);
    }

    /**
     * Get user info using access token (API endpoint)
     */
    public function userInfo(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));

        $accessToken = OAuthAccessToken::where('token', $token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$accessToken) {
            return response()->json(['error' => 'invalid_token'], 401);
        }

        $user = \App\Models\User::find($accessToken->user_id);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
