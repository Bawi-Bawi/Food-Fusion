<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'cuisine_id', 'category_id','title','description','image','difficulty','status','time_taken','view_count'];

    public function preferences()
    {
        return $this->belongsToMany(Preference::class, 'recipe__preferences','recipe_id', relatedPivotKey: 'preference_id');
    }
    public function cookBook()
    {
        return $this->hasOne(CookBook::class);
    }

}
