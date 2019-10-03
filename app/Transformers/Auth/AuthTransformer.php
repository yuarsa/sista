<?php

namespace App\Transformers\Auth;

use App\Models\Auth\User;
use League\Fractal\TransformerAbstract;

class AuthTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        if($user->area) {
            $area = [
                'area_id' => $user->area->area_id,
                'area_name' => $user->area->area_name,
            ];
        } else {
            $area = [];
        }

        $formatted = [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'name' => $user->name,
            'remember_token' => $user->remember_token,
            'shift' => $user->shift,
            'area' => $area,
            'enabled' => $user->enabled,
            'last_login_at' => (String) $user->last_login_at,
            'created_at' => (String) $user->created_at,
            'updated_at' => (String) $user->updated_at,
        ];

        return $formatted;
    }
}
