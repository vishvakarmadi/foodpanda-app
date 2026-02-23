<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OAuthClient extends Model
{
    protected $table = 'oauth_clients';
    protected $fillable = ['name', 'client_id', 'client_secret', 'redirect_uri'];
}
