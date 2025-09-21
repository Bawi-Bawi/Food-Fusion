<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'recipe_id','title'];
    public function ingredients()
    {
        return $this->hasMany(Ingredients::class, 'section_id');
    }
    public function directions()
    {
        return $this->hasMany(Directions::class, 'section_id');
    }
}
