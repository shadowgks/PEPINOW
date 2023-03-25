<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategorieRequest;
use App\Models\Categorie;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorie = Categorie::get();
        if (is_null($categorie)) {
            return response()->json(['status'=>false, 'msg'=>'Not found Any data!']);
        }
        return response()->json(['status'=>true, 'data'=>$categorie]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategorieRequest $request)
    {
        $create = Categorie::create($request->all());
        if (is_null($create)) {
            return response()->json(['status'=>false, 'msg'=>'Somthing not correct for this create country please try again!']);
        }
        return response()->json(['status'=>true, 'data'=>$create]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categorie = Categorie::find($id);
        if (is_null($categorie)) {
            return response()->json(['status'=>false, 'msg'=>'This Categorie not found!']);
        }
        return response()->json(['status'=>true, 'data'=>$categorie]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(CategorieRequest $request, $id)
    {
        $categorie = Categorie::find($id);
        if (is_null($categorie)) {
            return response()->json(['status'=>false, 'msg'=>'This Categorie not found!']);
        }
        $categorie->update($request->all());
        return response()->json(['status'=>true, 'data'=>$categorie]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categorie = Categorie::find($id);
        if (is_null($categorie)) {
            return response()->json(['status'=>false, 'msg'=>'This Categorie not found!']);
        }
        $categorie->delete();
        return response()->json(['status'=>false, 'msg'=>'Deleted Successfuly!']);
    }
}
