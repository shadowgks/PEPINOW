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
        $plant->load('categories');
        if (is_null($plant)) {
            return response()->json(['status' => false, 'msg' => 'Not found Any data!']);
        } else {
            return response()->json(['status' => true, 'data' => $plant]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function addCategories(CategoriePlantRequest $request, $id)
    {
        // dd($plant);
        $plant = Plant::find($id);
        if (is_null($plant)) {
            return response()->json(['status' => false, 'msg' => 'This Plant Not Exist!']);
        } else {
            $plant->categories()
                ->syncWithoutDetaching($request->categorie_id);
            return response()->json(['status' => true, 'msg' => 'Created Multiple Categories']);
        }
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

        //----------B Upload pictures--------------
        $fileName = time() . $request->picture->getClientOriginalName();
        $path = $request->picture->storeAs('picture', $fileName, 'public');
        //----------E Upload pictures--------------

        //store data
        $plant = Plant::create([
            'name' => $request->name,
            'picture' => '/storage/' . $path,
            'price' => $request->price,
            'description' => $request->description,
            'user_id' => $id
        ]);

        //added many categories
        $plant->categories()
            ->syncWithoutDetaching($request->categorie_id);
        return response()->json(['status' => true, 'msg' => 'Created Success']);
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
        return response()->json(['status' => true, 'data' => $plant->load('categories')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */

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
            return response()->json(['status' => false, 'msg' => 'This Plant Not Exist!']);
        } else {
            $inputs = $request->all();
            $picture = $request->picture;
            //----------B Upload pictures--------------
            if ($picture) {
                $fileName = time() . $picture->getClientOriginalName();
                $path = $picture->storeAs('images', $fileName, 'public');
                $inputs["picture"] = 'storage/' . $path;
            } else {
                unset($inputs["picture"]);
            }
            //----------E Upload pictures--------------
            $plant->update($inputs);
            return response()->json(['status' => true, 'data' => $plant]);
        }
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
            return response()->json(['status' => false, 'msg' => 'This Plant Not Exist!']);
        } else {
            $plant->delete();
            return response()->json(['status' => true, 'msg' => 'Deleted Successfuly']);
        }
    }
}
