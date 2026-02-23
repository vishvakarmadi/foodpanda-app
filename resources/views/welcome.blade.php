@extends('layouts.app')
@section('title', 'Foodpanda - Welcome')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8 text-center text-white">
        <i class="fas fa-utensils fa-5x mb-4"></i>
        <h1 class="display-4 fw-bold mb-3">Welcome to Foodpanda</h1>
        <p class="lead mb-4">Your favorite food delivery platform. Order from the best restaurants near you.</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4" style="border-radius:12px; font-weight:600;">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4" style="border-radius:12px; font-weight:600;">
                <i class="fas fa-user-plus me-2"></i>Register
            </a>
        </div>
    </div>
</div>
@endsection
