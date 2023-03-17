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
            return response()->json('Not found Any data!', 404);
        }
        return response()->json($categorie, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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
            return response()->json('Somthing not correct for this create country please try again!', 404);
        }
        return response()->json($create, 201);
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
            return response()->json('Categorie not found!', 404);
        }
        return response()->json($categorie, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorie $categorie)
    {
        //
    }

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
            return response()->json('Somthing not correct for this update categorie please try again!', 404);
        }
        $categorie->update($request->all());
        return response()->json($categorie, 200);
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
            return response()->json('Not found this categorie!', 404);
        }
        $categorie->delete();
        return response()->json(null, 204);
    }
}
