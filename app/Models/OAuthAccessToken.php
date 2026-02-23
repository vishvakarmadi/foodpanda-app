<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OAuthAccessToken extends Model
{
    protected $table = 'oauth_access_tokens';
    protected $fillable = ['user_id', 'client_id', 'token', 'expires_at'];
    protected $casts = ['expires_at' => 'datetime'];
}
