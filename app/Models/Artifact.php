<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MatanYadaev\EloquentSpatial\SpatialBuilder;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
use Illuminate\Database\Eloquent\SoftDeletes;
Use App\Models\Image;
Use App\Models\User;
Use App\Models\Person;

/**
 * @property Point $location
 * @property Polygon $area
 */
class Artifact extends Model
{
    use HasFactory, HasSpatial;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'location',
        'area',
        'address',
        'city',
        'state',
        'zipcode',
        'eloGroup',
        'scale',
        'temp',
        'initial_year',
        'grade',
        'primary_image_id'
    ];

    protected $casts = [
        'location' => Point::class,
        'area' => Polygon::class,
        'deleted_at' => 'datetime'
    ];
    public function images()
    {
        return $this->belongsToMany(Image::class, 'artifacts_images', 'artifacts_id','images_id');
    }

    // a user is an editor - not necessarily involved in the artifact itself 
    public function users()
    {
        return $this->belongsToMany(User::class, 'artifacts_users', 'artifacts_id','users_id');
    }     

    // a person is an architect etc
    public function persons()
    {
        return $this->belongsToMany(Person::class, 'artifacts_persons', 'artifacts_id','persons_id');
    }    
}