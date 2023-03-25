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

class UpdateProfile extends Controller
{
    public function updateProfilUser(Request $request){
        $user = Auth::user();
        if($user){
            $request->validate([
                'name' => 'required|min:2',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed'
            ]);

            $user->name = $request->name;
            $user->password =  Hash::make($request->password);
            $user->email = $request->email;
            $user->save();

            $data = [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'status' => 200,
            ];

            return response()->json(['Success'=>True,
            'data' =>$data,
            'msg'=>'Updated Profile Success']);
        }else{
            return response()->json(['Success'=>false, 'msg'=>'This User Not Authenticated']);
        }
    }
}
