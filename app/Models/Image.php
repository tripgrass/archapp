<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
Use App\Models\Artifact;
Use App\Models\Person;

  
class Image extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'name',
        'title',
        'year',
        'alttext',

    ];

    protected $attributes = [
    ];    

    public function artifacts()
    {
        return $this->belongsToMany(Artifact::class, 'artifacts_images', 'images_id', 'artifacts_id');
    } 

    /**
     * Get the person that owns the image.
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }       
}