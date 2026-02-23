@extends('layouts.app')
@section('title', 'Register - Foodpanda')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card p-4">
            <div class="card-body">
                <div class="text-center mb-4">
                    <i class="fas fa-user-plus fa-3x text-danger mb-3"></i>
                    <h3 class="fw-bold">Create Account</h3>
                    <p class="text-muted">Join Foodpanda today</p>
                </div>
                <form method="POST" action="{{ route('register.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Your name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Min 6 characters" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                    </div>
                    <button type="submit" class="btn btn-foodpanda w-100 mt-2">
                        <i class="fas fa-user-plus me-2"></i>Register
                    </button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none" style="color: #d70f64;">Already have an account? Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
