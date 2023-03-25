<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all();
        if (is_null($role)) {
        }else{
            return response()->json(['Success'=>true, 'data'=>$role]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
        ]);
        $create = Role::create($request->all());
        if (is_null($create)) {
            return response()->json(['Success'=>false, 'msg'=>'Somthing not correct for this create role please try again!']);
        }else{
            return response()->json(['Success'=>true, 'msg'=>'Created Successfuly']);
        }
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if (is_null($role)) {
            return response()->json(['Success'=>false, 'msg'=>'Somthing not correct for this update role please try again!']);
        }else{
            $role->update($request->all());
            return response()->json(['Success'=>true, 'msg'=>'Role update with success']);
        }
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        if (is_null($role)) {
            return response()->json(['Success'=>false, 'msg'=>'Deleted failed!']);
        }else{
            $role->delete();
            return response()->json(['Success'=>true, 'msg'=>'Deleted Success']);
        }
    }
}
