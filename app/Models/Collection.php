<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Models\Artifact;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'public',
        'brand_id',
        'image_id'
    ];

    public function artifacts()
    {
        return $this->belongsToMany(Artifact::class, 'artifacts_collections', 'collections_id','artifacts_id');
    }


}
