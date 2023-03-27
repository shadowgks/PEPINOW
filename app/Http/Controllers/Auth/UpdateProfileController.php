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

class UpdateProfileController extends Controller
{
    public function updateProfilUser(Request $request)
    {
        $user = Auth::user();
        if($user){
            $request->validate([
                'name' => 'min:2',
                'password' => 'min:8|confirmed',
            ]);

            $user->name = $request->name;
            $user->password =  Hash::make($request->password);
            $user->save();

            $data = [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'role' => $user->role,
            ];

            return response()->json(['Success'=>True,
            'data' =>$data,
            'msg'=>'Updated Profile Successfuly']);
        }else{
            return response()->json(['Success'=>false, 'msg'=>'This User Not Authenticated']);
        }
    }
}
