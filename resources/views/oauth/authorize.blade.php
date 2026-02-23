@extends('layouts.app')
@section('title', 'Authorize - Foodpanda')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header text-center bg-danger text-white">
                <h5 class="mb-0">Authorization Request</h5>
            </div>
            <div class="card-body text-center p-4">
                <p><strong>{{ $client->name }}</strong> wants to access your Foodpanda account.</p>

                <div class="bg-light rounded p-3 mb-4 text-start">
                    <p class="mb-1"><strong>Logged in as:</strong> {{ Auth::user()->email }}</p>
                    <p class="mb-0"><strong>Redirect to:</strong> <code>{{ $params['redirect_uri'] }}</code></p>
                </div>

                <div class="d-flex gap-2 justify-content-center">
                    <form method="POST" action="{{ route('oauth.authorize.approve') }}">
                        @csrf
                        <button type="submit" class="btn btn-success px-4">Authorize</button>
                    </form>
                    <form method="POST" action="{{ route('oauth.authorize.deny') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary px-4">Deny</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
