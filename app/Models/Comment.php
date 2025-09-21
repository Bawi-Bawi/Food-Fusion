<?php

namespace App\Models;

use Hoa\Event\Listens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['cook_book_id', 'user_id', 'comment'];

    public function cookBook()
    {
        return $this->belongsTo(CookBook::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
