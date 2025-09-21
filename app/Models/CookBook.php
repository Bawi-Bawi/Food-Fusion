<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookBook extends Model
{
    use HasFactory;
    protected $fillable = ['recipe_id','reaction','published_at'];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
