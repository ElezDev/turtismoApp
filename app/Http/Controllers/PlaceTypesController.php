<?php

namespace App\Http\Controllers;

use App\Models\PlaceTypes;
use Illuminate\Http\Request;

class PlaceTypesController extends Controller

    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $PlaceTypess = PlaceTypes::all();
            return response()->json($PlaceTypess);
        }
    
        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            $data = $request->all();
            $PlaceTypes = new PlaceTypes($data);
            $PlaceTypes->save();
            return response()->json($PlaceTypes, 201);
        }
    
        /**
         * Display the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function show(int $id)
        {
            $PlaceTypes = PlaceTypes::find($id);
            return response()->json($PlaceTypes);
        }
    
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, int $id)
        {
            $data = $request->all();
            $PlaceTypes = PlaceTypes::findOrFail($id);
            $PlaceTypes->fill($data);
            $PlaceTypes->save();
            return response()->json($PlaceTypes);
        }
    
        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(int $id)
        {
            $PlaceTypes = PlaceTypes::findOrFail($id);
            $PlaceTypes->delete();
            return response()->json([], 204);
        }
    }
    