<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateRoleController extends Controller
{
    public function updateRoleUser(Request $request, $id)
    {
        if ($id == Auth::user()->id) {
            return response()->json(['Success' => false, 'msg' => 'This is your id']);
        } else {
            $user = User::find($id);
            if ($user) {
                $request->validate([
                    'role' => 'required|integer',
                ]);

                $user->role = $request->role;
                $user->save();

                $data = [
                    'status' => true,
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'role' => $user->role,
                ];

                return response()->json([
                    'Success' => True,
                    'data' => $data,
                    'msg' => 'Updated Role User Successfuly'
                ]);
            } else {
                return response()->json(['Success' => false, 'msg' => 'This User Not Authenticated']);
            }
        }
    }
}
