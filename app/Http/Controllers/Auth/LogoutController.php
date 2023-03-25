<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends Controller
{
    public function logout()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return  $this->returnError('E404', 'user_not_found!');
            }
        } catch (TokenExpiredException $e) {
            return response()->json("token_expired");
        } catch (TokenInvalidException $e) {
            return response()->json("token_invalid!");
        } catch (JWTException $e) {
            return response()->json("token_absent!");
        }

        Auth::logout();
        return response()->json("Logout has been success!");
    }
}
