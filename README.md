# Foodpanda App (SSO Server)

This is a Laravel app that acts as the OAuth2 provider for SSO.
Users register and login here. Other apps (like Ecommerce) can use this for login.

## How SSO Works

Foodpanda acts as the OAuth server. When another app wants to authenticate a user:

1. It redirects the user to Foodpanda's `/oauth/authorize` endpoint
2. User logs in (if not already) and clicks "Authorize"
3. Foodpanda generates an auth code and redirects back to the client app
4. The client app exchanges the code for an access token via `/oauth/token`
5. The client app fetches user info via `/api/user` using the token

### OAuth Endpoints

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/oauth/authorize` | GET | Show authorization page |
| `/oauth/token` | POST | Exchange auth code for token |
| `/api/user` | GET | Get user info (needs Bearer token) |

## Tech Stack

- Laravel 11
- Bootstrap 5
- MySQL

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Update `.env` with database credentials:
```
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_pass
```

Run migrations and seed:
```bash
php artisan migrate
php artisan db:seed
```

This creates:
- Demo user: `test@example.com` / `12345678`
- OAuth client for ecommerce app

Start the server:
```bash
php artisan serve --port=8000
```

## Live Demo

- URL: https://foodpanda-app.kisusoft.com
- Credentials: test@example.com / 12345678
