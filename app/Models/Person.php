<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Models\Artifact;
Use App\Models\Image;
Use App\Models\Persona;

  
class Person extends Model
{

    use HasFactory;
    protected $table = 'persons';

    protected $fillable = [
        'firstName',
        'lastName',
        'birthDate'
    ];

    protected $attributes = [
    ];    

    public function artifacts()
    {
        return $this->belongsToMany(Artifact::class, 'artifacts_persons', 'persons_id', 'artifacts_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'images_persons', 'persons_id', 'images_id');
    }

    public function personas()
    {
        return $this->belongsToMany(Persona::class, 'personas_persons', 'persons_id','personas_id');
    }
            
}