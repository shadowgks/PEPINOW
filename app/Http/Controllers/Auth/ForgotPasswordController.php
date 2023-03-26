<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Exception;


class ForgotPasswordController extends Controller
{
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
}
