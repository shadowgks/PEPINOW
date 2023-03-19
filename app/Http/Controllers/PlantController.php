<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriePlantRequest;
use App\Http\Requests\PlantRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plant = Plant::all();
        if (is_null($plant)) {
            return response()->json('Not found Any data!', 404);
        }
        return response()->json($plant, 200);
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

    public function addCategories(CategoriePlantRequest $request, $id){
        // dd($plant);
        $plant = Plant::find($id);
        $plant->categories()
        ->syncWithoutDetaching($request->categorie_id);
        return 'Created Multiple Categories';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlantRequest $request)
    {
        $id = Auth::user()->id; //current user
        $plant = Plant::create([
            'name' => $request->name,
            'picture' => $request->picture,
            'price' => $request->price,
            'description' => $request->description,
            'user_id' => $id
        ]);
        return response()->json('Created Success', 201);
    }

    public function addCategorie(Request $request, Plant $plant)
    {
        $plant->categories()->attach($request->categorie);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plant = Plant::find($id);
        return $plant->load('categories');
        // $plate = Plant::find($id);
        // if (is_null($plate)) {
        //     return response()->json('Plant not found!', 404);
        // }
        // return response()->json($plate, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function update(PlantRequest $request, $id)
    {
        $plant = Plant::find($id);
        if (is_null($plant)) {
            return response()->json('Somthing not correct for this update plant please try again!', 404);
        }
        $plant->update($request->all());
        return response()->json($plant, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plant = Plant::find($id);
        if (is_null($plant)) {
            return response()->json('Not found this plant!', 404);
        }
        $plant->delete();
        return response()->json(null, 204);
    }
}
