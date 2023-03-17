<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlantRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Plant;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plant = Plant::get();
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
            'categorie_id' => $request->categorie_id,
            'user_id' => $id
        ]);
        return response()->json('Created Success', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plate = Plant::find($id);
        if (is_null($plate)) {
            return response()->json('Plant not found!', 404);
        }
        return response()->json($plate, 200);
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
