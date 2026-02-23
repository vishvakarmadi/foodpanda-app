@extends('layouts.app')
@section('title', 'Login - Foodpanda')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card p-4">
            <div class="card-body">
                <div class="text-center mb-4">
                    <i class="fas fa-utensils fa-3x text-danger mb-3"></i>
                    <h3 class="fw-bold">Login to Foodpanda</h3>
                    <p class="text-muted">Enter your credentials to continue</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="test@example.com" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                    </div>
                    <button type="submit" class="btn btn-foodpanda w-100 mt-2">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('register') }}" class="text-decoration-none" style="color: #d70f64;">Don't have an account? Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
