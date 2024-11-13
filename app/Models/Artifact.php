<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MatanYadaev\EloquentSpatial\SpatialBuilder;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
Use App\Models\Image;
Use App\Models\User;

/**
 * @property Point $location
 * @property Polygon $area
 */
class Artifact extends Model
{
    use HasFactory, HasSpatial;

    protected $fillable = [
        'name',
        'location',
        'area',
        'address',
        'city',
        'state',
        'zipcode',
        'eloGroup',
        'scale'
    ];

    protected $casts = [
        'location' => Point::class,
        'area' => Polygon::class,
    ];

    public function images()
    {
        return $this->belongsToMany(Image::class, 'artifacts_images', 'artifacts_id','images_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'artifacts_users', 'artifacts_id','users_id');
    }     
}