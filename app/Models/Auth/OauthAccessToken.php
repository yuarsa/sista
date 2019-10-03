<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{
    protected $table = 'oauth_access_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'client_id',
        'name',
        'scopes',
        'revoked',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'expires_at'
    ];
}
