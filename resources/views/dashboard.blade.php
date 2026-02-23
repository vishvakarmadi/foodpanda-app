@extends('layouts.app')
@section('title', 'Dashboard - Foodpanda')
@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="card p-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="fas fa-user fa-2x text-danger"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">Welcome, {{ Auth::user()->name }}!</h3>
                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <hr>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card bg-danger bg-opacity-10 border-0">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-utensils fa-3x text-danger mb-3"></i>
                                <h5 class="fw-bold">Food Orders</h5>
                                <p class="text-muted">Manage your food orders</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning bg-opacity-10 border-0">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-heart fa-3x text-warning mb-3"></i>
                                <h5 class="fw-bold">Favorites</h5>
                                <p class="text-muted">Your favorite restaurants</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success bg-opacity-10 border-0">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-map-marker-alt fa-3x text-success mb-3"></i>
                                <h5 class="fw-bold">Addresses</h5>
                                <p class="text-muted">Saved delivery addresses</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>SSO Info:</strong> You are logged in as <strong>{{ Auth::user()->email }}</strong>. 
                        Other apps (like Ecommerce) can use your Foodpanda account for SSO login.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
