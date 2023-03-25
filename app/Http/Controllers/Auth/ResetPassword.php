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

class ResetPassword extends Controller
{
    public function resetpassword(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if(Hash::check($request->old_password, $user->password)){
            $user->update([
                'password' => hash::make($request->new_password),
            ]);
            return response()->json(['statut'=>true, 'msg'=>'updated succesfuly']);
        }else{
            return response()->json(['statut'=>false, 'msg'=>'old password does not matched!']);
        }
    }
}
