<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceTypes extends Model
{
    use HasFactory;
    public static $snakeAttributes = false;
    protected $table = "place_types";
    protected $guarded = [];

    public $timestamps = false;
}
