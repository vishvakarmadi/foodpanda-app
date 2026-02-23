@extends('layouts.app')
@section('title', 'Authorize Application - Foodpanda')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card p-4">
            <div class="card-body text-center">
                <i class="fas fa-shield-alt fa-3x text-danger mb-3"></i>
                <h4 class="fw-bold mb-3">Authorization Request</h4>
                <p class="text-muted mb-4">
                    <strong>{{ $client->name }}</strong> is requesting access to your Foodpanda account.
                </p>

                <div class="bg-light rounded-3 p-3 mb-4">
                    <p class="mb-1"><i class="fas fa-user me-2 text-danger"></i>Logged in as: <strong>{{ Auth::user()->email }}</strong></p>
                    <p class="mb-0"><i class="fas fa-globe me-2 text-danger"></i>Redirect to: <code>{{ $params['redirect_uri'] }}</code></p>
                </div>

                <div class="d-flex gap-3 justify-content-center">
                    <form method="POST" action="{{ route('oauth.authorize.approve') }}">
                        @csrf
                        <button type="submit" class="btn btn-foodpanda px-4">
                            <i class="fas fa-check me-2"></i>Authorize
                        </button>
                    </form>
                    <form method="POST" action="{{ route('oauth.authorize.deny') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary px-4" style="border-radius:12px;">
                            <i class="fas fa-times me-2"></i>Deny
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
