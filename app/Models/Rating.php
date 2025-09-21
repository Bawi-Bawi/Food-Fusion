<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = ['cook_book_id','rating'];
    public function cookBook()
    {
        return $this->belongsTo(CookBook::class);
    }
}
