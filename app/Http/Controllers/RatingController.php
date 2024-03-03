<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, $placeId)
    {
        $request->validate([
            'rating' => 'required|numeric|between:1,5', 
        ]);
        
        $place = Place::find($placeId);
    
        if (!$place) {
            return response()->json(['message' => 'Lugar no encontrado'], 404);
        }
    
        $existingRating = Rating::where('place_id', $place->id)
                                ->where('user_id', Auth::id())
                                ->first();
    
        if ($existingRating) {
            $existingRating->rating = $request->rating;
            $existingRating->save();
            return response()->json(['message' => 'Calificación actualizada con éxito'], 200);
        } else {
            $rating = new Rating();
            $rating->place_id = $place->id;
            $rating->user_id = Auth::id();
            $rating->rating = $request->rating;
            $rating->save();
            return response()->json(['message' => 'Calificación guardada con éxito'], 200);
        }
    }
    
}
