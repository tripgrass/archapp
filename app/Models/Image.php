<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Image extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'name',
        'rating_signatory',
        'rating_demos'
    ];

    protected $attributes = [
        'rating_signatory' => 0,
        'rating_demos' => 0
    ];    

    public function artifacts()
    {
        return $this->belongsToMany(Artifact::class, 'artifacts_images', 'images_id', 'artifacts_id');
    }    
}