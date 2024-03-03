<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SaveFile;


class Place extends Model
{
    use HasFactory, SaveFile;
    public static $snakeAttributes = false;
    protected $table = "places";
    protected $guarded = [];

    const PATH = "places";

    const RUTA_LOGO_DEFAULT = "/default/logo.jpg";
    protected $appends = ['rutaImageUrl'];

    public $timestamps = false;


    public function getrutaImageUrlAttribute()
    {
        if (
            isset($this->attributes['images_url']) &&
            isset($this->attributes['images_url'][0])
        ) {
            return url($this->attributes['images_url']);
        }
        return url(self::RUTA_LOGO_DEFAULT);
    }
 

    public function storeLogo($request)
    {
        $path = '/default/logo.jpg';

        if (isset($this->attributes['images_url'])) {
            $path = $this->attributes['images_url'];
        }
        $this->attributes['images_url'] = $this->storeFile($request, 'imageUrl', self::PATH, $path);
    }

    public function placeType()
    {
        return $this->belongsTo(PlaceTypes::class, 'typePlaceId', 'id');
    }
    
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}
