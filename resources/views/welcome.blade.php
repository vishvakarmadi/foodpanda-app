@extends('layouts.app')
@section('title', 'Foodpanda - Welcome')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6 text-center">
        <div class="card">
            <div class="card-body p-5">
                <i class="fas fa-utensils fa-3x text-danger mb-3"></i>
                <h2>Welcome to Foodpanda</h2>
                <p class="text-muted">Food delivery platform. Login or register to get started.</p>
                <div class="d-flex gap-2 justify-content-center mt-3">
                    <a href="{{ route('login') }}" class="btn btn-danger px-4">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-danger px-4">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
