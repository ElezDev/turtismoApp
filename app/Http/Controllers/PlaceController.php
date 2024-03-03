<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index()
     {
         $places = Place::with(['ratings', 'placeType', 'ratings.user'])->get();
         return response()->json($places);
     }
     

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $place = new Place();
        $place->name = $request->input('name');
        $place->description = $request->input('description');
        $place->latitude = $request->input('latitude');
        $place->longitude = $request->input('longitude');
        $place->typePlaceId = $request->input('typePlaceId');
        $place->address = $request->input('address');
        $place->opening_hours = $request->input('opening_hours');
        $place->average_rating = $request->input('average_rating');
        $place->storeLogo($request);
        $place->save();
        return response()->json($place, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        return response()->json($place);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'typePlaceId' => 'required|exists:place_types,id',
            'address' => 'required|string',
            'images_url' => 'required|string',
            'opening_hours' => 'nullable|string',
            'average_rating' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $place->update($request->all());

        return response()->json($place, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        $place->delete();

        return response()->json(null, 204);
    }
}
