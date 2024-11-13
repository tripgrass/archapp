<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Models\Artifact;

  
class Image extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'name',
    ];

    protected $attributes = [
    ];    

    public function artifacts()
    {
        return $this->belongsToMany(Artifact::class, 'artifacts_images', 'images_id', 'artifacts_id');
    }    
}