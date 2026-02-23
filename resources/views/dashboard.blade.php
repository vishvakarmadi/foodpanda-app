@extends('layouts.app')
@section('title', 'Dashboard - Foodpanda')
@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-4">
                <h4>Welcome, {{ Auth::user()->name }}!</h4>
                <p class="text-muted">{{ Auth::user()->email }}</p>
                <hr>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-utensils fa-2x text-danger mb-2"></i>
                                <h6>Food Orders</h6>
                                <small class="text-muted">Manage orders</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-heart fa-2x text-warning mb-2"></i>
                                <h6>Favorites</h6>
                                <small class="text-muted">Saved restaurants</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-map-marker-alt fa-2x text-success mb-2"></i>
                                <h6>Addresses</h6>
                                <small class="text-muted">Delivery locations</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-4 mb-0">
                    <strong>SSO:</strong> You are logged in as {{ Auth::user()->email }}.
                    Other apps like Ecommerce can use your Foodpanda account to login via SSO.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
