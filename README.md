# Foodpanda App (OAuth2 Server)

## Developer: Aditya Vishvakarma

---

## About

Foodpanda application that acts as an **OAuth2 authorization server**. It handles user authentication and provides SSO (Single Sign-On) for the Ecommerce app.

## How It Works

- Users can register and login directly on the Foodpanda app
- When the Ecommerce app requests OAuth authorization, this app:
  1. Shows the login page (if not logged in)
  2. Shows an authorization consent screen
  3. Issues an authorization code
  4. Exchanges the code for an access token
  5. Provides user info via API endpoint

## OAuth Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/oauth/authorize` | GET | Authorization request |
| `/oauth/token` | POST | Token exchange |
| `/api/user` | GET | Get user info (Bearer token) |

## Tech Stack

- Laravel 11 (PHP 8.2+)
- MySQL
- Bootstrap 5
- Custom OAuth2 implementation (no Passport)

## Setup

```bash
# clone and install
git clone https://github.com/vishvakarmadi/foodpanda-app.git
cd foodpanda-app
composer install

# configure
cp .env.example .env
php artisan key:generate
```

Update `.env`:
```
DB_DATABASE=foodpanda_db
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# create database, run migrations and seed
php artisan migrate
php artisan db:seed

# start server on port 8000
php artisan serve --port=8000
```

## Demo Credentials

- **Email:** test@example.com
- **Password:** 12345678

## Seeded OAuth Client

| Field | Value |
|-------|-------|
| Client ID | `ecommerce-client` |
| Client Secret | `secret123abc` |
| Redirect URI | `http://localhost:8001/sso/callback` |

## Project Structure

```
app/
├── Http/Controllers/
│   ├── AuthController.php      # login, register, logout
│   └── OAuthController.php     # OAuth2 server logic
├── Models/
│   ├── User.php
│   ├── OAuthClient.php
│   ├── OAuthAuthCode.php
│   └── OAuthAccessToken.php
resources/views/
├── auth/login.blade.php
├── auth/register.blade.php
├── oauth/authorize.blade.php   # consent screen
├── dashboard.blade.php
└── layouts/app.blade.php
database/
├── migrations/
│   └── create_oauth_clients_table.php
└── seeders/
    └── DatabaseSeeder.php      # test user + OAuth client
```
