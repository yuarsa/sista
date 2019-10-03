<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class OauthRefreshToken extends Model
{
    protected $table = 'oauth_refresh_tokens';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'access_token_id',
        'revoked'
    ];

    protected $dates = [
        'expires_at'
    ];
}
