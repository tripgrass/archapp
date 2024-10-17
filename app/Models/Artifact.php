<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\SpatialBuilder;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;

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
    ];

    protected $casts = [
        'location' => Point::class,
        'area' => Polygon::class,
    ];
}