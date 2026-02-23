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
    // show authorization page or redirect to login
    public function authorize(Request $request)
    {
        $request->validate([
            'client_id' => 'required|string',
            'redirect_uri' => 'required|url',
            'response_type' => 'required|in:code',
        ]);

        $client = OAuthClient::where('client_id', $request->client_id)->first();

        if (!$client || $client->redirect_uri !== $request->redirect_uri) {
            return response()->json(['error' => 'Invalid client'], 400);
        }

        // save oauth params in session
        $request->session()->put('oauth_params', [
            'client_id' => $request->client_id,
            'redirect_uri' => $request->redirect_uri,
            'response_type' => $request->response_type,
            'state' => $request->state,
        ]);

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('oauth.authorize', [
            'client' => $client,
            'params' => $request->session()->get('oauth_params'),
        ]);
    }

    // show consent form if already logged in
    public function showAuthorizeForm(Request $request)
    {
        $params = $request->session()->get('oauth_params');
        if (!$params) return redirect()->route('dashboard');

        $client = OAuthClient::where('client_id', $params['client_id'])->first();
        return view('oauth.authorize', compact('client', 'params'));
    }

    // user clicked "Authorize"
    public function approveAuthorize(Request $request)
    {
        $params = $request->session()->get('oauth_params');
        if (!$params) return redirect()->route('dashboard');

        $code = Str::random(40);

        OAuthAuthCode::create([
            'user_id' => Auth::id(),
            'client_id' => $params['client_id'],
            'code' => $code,
            'expires_at' => now()->addMinutes(10),
        ]);

        $request->session()->forget('oauth_params');

        $redirect = $params['redirect_uri'] . '?' . http_build_query([
            'code' => $code,
            'state' => $params['state'] ?? '',
        ]);

        return redirect($redirect);
    }

    // user clicked "Deny"
    public function denyAuthorize(Request $request)
    {
        $params = $request->session()->get('oauth_params');
        $request->session()->forget('oauth_params');

        if ($params) {
            $redirect = $params['redirect_uri'] . '?' . http_build_query([
                'error' => 'access_denied',
                'state' => $params['state'] ?? '',
            ]);
            return redirect($redirect);
        }

        return redirect()->route('dashboard');
    }

    // token endpoint - exchange auth code for access token
    public function token(Request $request)
    {
        $request->validate([
            'grant_type' => 'required|in:authorization_code',
            'code' => 'required|string',
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'redirect_uri' => 'required|string',
        ]);

        $client = OAuthClient::where('client_id', $request->client_id)
            ->where('client_secret', $request->client_secret)
            ->first();

        if (!$client) {
            return response()->json(['error' => 'invalid_client'], 401);
        }

        $authCode = OAuthAuthCode::where('code', $request->code)
            ->where('client_id', $request->client_id)
            ->where('expires_at', '>', now())
            ->first();

        if (!$authCode) {
            return response()->json(['error' => 'invalid_grant'], 400);
        }

        $token = Str::random(80);

        OAuthAccessToken::create([
            'user_id' => $authCode->user_id,
            'client_id' => $request->client_id,
            'token' => $token,
            'expires_at' => now()->addDays(30),
        ]);

        $authCode->delete();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 2592000,
        ]);
    }

    // api endpoint - return user info for given token
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
