<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auth\OauthRefreshToken;
use App\Models\Auth\User;
use App\Transformers\Auth\AuthTransformer;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $authTransformer;

    public function __construct(AuthTransformer $authTransformer)
    {
        parent::__construct();

        $this->authTransformer = $authTransformer;
    }

    public function login(Request $request)
    {
        $email = $request->email;

        $password = $request->password;

        $user = User::where('username', $email)->first();

        if($user) {
            if(Hash::check($password, $user->password)) {
                $client = \Laravel\Passport\Client::where('password_client', 1)->first();

                $access = [
                    'grant_type' => 'password',
                    'client_id' => $client->id,
                    'client_secret' => $client->secret,
                    'username' => $user->email,
                    'password' => $password,
                    'scope' => ''
                ];

                $token = $request->create('/oauth/token', 'POST', $access);

                return app()->handle($token);
            } else {
                return $this->withCustomErrorResponse(422, 'Password Incorrect');
            }
        } else {
            return $this->withCustomErrorResponse(422, 'Username doest not exist');
        }
    }

    public function logout()
    {
        $token = \Auth::user()->token();

        OauthRefreshToken::where('access_token_id', $token->id)->update(['revoked' => 1]);

        $token->revoke();

        return $this->withCustomResponse(200, 'User logged out successfully', '');
    }

    public function detail()
    {
        $user = \Auth::user();

        return $this->withItemResponse($user, $this->authTransformer);
    }
}
