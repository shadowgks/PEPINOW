<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = auth('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    // Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    // Logout
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

    // Me
    public function me()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::guard('api')->user(),
        ]);
    }

    // Refresh
    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    // forgotPassword
    public function forgotPassword(Request $request)
    {
        $validatedData =$request->validate([
            'email' => 'required|string|email|max:255|exists:users',
        ]);

        $response = Password::sendResetLink($validatedData);

        return $response == Password::RESET_LINK_SENT
            ? response()->json(['success' => true])
            : response()->json(['error' => 'Failed to send reset link'], 500);
    }

    // resetPaswsword
    public function resetpassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
                $user->save();
            }
        );
        return $response == Password::PASSWORD_RESET
            ? response()->json(['success' => true])
            : response()->json(['error' => 'Failed to reset password'], 500);
    }

    // updateProfile
    public function updateProfilUser(Request $request){
        $user = Auth::user();
        if($user){
            $request->validate([
                // 'id' => $user->id,
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
