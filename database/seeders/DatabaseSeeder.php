<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\OAuthClient;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('12345678'),
            ]
        );

        // Create OAuth client for ecommerce-app
        OAuthClient::updateOrCreate(
            ['client_id' => 'ecommerce-client'],
            [
                'name' => 'Ecommerce App',
                'client_secret' => 'secret123abc',
                'redirect_uri' => 'https://ecommerce-app.kisusoft.com/sso/callback',
            ]
        );
    }
}
