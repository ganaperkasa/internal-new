<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use DB;

class AuthToken extends Model
{
    protected $table = "auth_token";

    public static function login($user_id, $user_name)
    {
        try {
            $auth_token = AuthToken::where('user_id', $user_id)->where('status', 1)->first();

            if(empty($auth_token)) {
                $user = User::find($user_id);
                $auth_key = $user->createToken($user_name)->accessToken;

                $user_auth = new AuthToken();
                $user_auth->user_id     = $user_id;
                $user_auth->auth_key    = $auth_key;
                $user_auth->status      = 1;
                $user_auth->save();

                return $user_auth;
            }

            return $auth_token;
        }
        catch (\Illuminate\Database\QueryException $e) {
            return $e;
        }
    }

    public static function logout($user_id)
    {
        try {
            $user = User::find($user_id);
            $userTokens = $user->tokens;
            foreach($userTokens as $token) {
                $token->revoke();
            }
            $auth_token = AuthToken::where('user_id', $user_id)->where('status', 1)->first();
            $auth_token->status       = 0;
            $auth_token->save();
            return $auth_token;
        }
        catch (\Illuminate\Database\QueryException $e) {
            return $e;
        }
    }
}
