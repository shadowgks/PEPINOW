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
        // $plant = Plant::get();
        // if (is_null($plant)) {
        //     return $this->returnError('E030', 'Not Found Any Plants!');
        // }
        // return $this->returnData("plant", $plant, "Find Plants", "");
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
        $validated = $request->validated();
        if (!$validated) {
            return response()->json($validated->errors(), 400);
        }
        $id = optional(Auth::user())->id; //current user
        $plant = Plant::create([
            'name' => $request->name,
            'picture' => $request->picture,
            'price' => $request->price,
            'description' => $request->description,
            'categorie_id' => $request->categorie_id,
            'user_id' => $id
        ]);
        if (is_null($plant)) {
            return response()->json('Somthing not correct for this create role please try again!', 401);
        }
        response()->json('Created Success', 204);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function show(Plant $plant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function edit(Plant $plant)
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
    public function update(PlantRequest $request, Plant $plant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plant $plant)
    {
        //
    }
}
