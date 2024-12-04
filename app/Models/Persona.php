<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Models\Person;
  
class Persona extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'title'
    ];

    protected $attributes = [
    ];    

    public function persons()
    {
        return $this->belongsToMany(Person::class, 'personas_persons', 'personas_id', 'persons_id');
    }
}