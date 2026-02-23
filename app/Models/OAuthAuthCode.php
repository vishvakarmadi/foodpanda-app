<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OAuthAuthCode extends Model
{
    protected $table = 'oauth_auth_codes';
    protected $fillable = ['user_id', 'client_id', 'code', 'expires_at'];
    protected $casts = ['expires_at' => 'datetime'];
}
