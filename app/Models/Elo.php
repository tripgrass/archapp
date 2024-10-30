<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elo extends Model
{
    use HasFactory;
    protected $fillable = [
        'primary_artifact_id',
        'secondary_artifact_id',
        'rating_signatory',
        'rating_demos',
        'category'
    ];

/*
    public function artifacts()
    {
        return $this->belongsToMany(Artifact::class, 'artifacts_images', 'images_id', 'artifacts_id');
    }        
    */
}
