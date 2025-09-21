<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rating;
use App\Models\Sections;
use App\Models\Ingredients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CookBookController extends Controller
{
    // direct cookbook page
    public function index()
    {
        $userId = Auth::id();

        $userCookBooks = DB::table('recipes')
            ->leftJoin('cook_books', 'recipes.id', '=', 'cook_books.recipe_id')
            ->leftJoin('comments', 'cook_books.id', '=', 'comments.cook_book_id')
            ->leftJoin('ratings', 'cook_books.id', '=', 'ratings.cook_book_id')
            ->leftJoin('users','recipes.user_id','=','users.id')
            ->select(
                'recipes.id as recipe_id',
                'recipes.title',
                'recipes.description',
                'recipes.difficulty',
                'recipes.time_taken',
                'recipes.status',
                'recipes.image',
                'cook_books.id as cook_book_id',
                'cook_books.reaction',
                'cook_books.published_at',
                DB::raw('COUNT(comments.id) as comments_count'),
                DB::raw('AVG(ratings.rating) as average_rating')
            )
            ->where('recipes.user_id', $userId)
            ->groupBy(
                'recipes.id',
                'recipes.title',
                'recipes.description',
                'recipes.difficulty',
                'recipes.time_taken',
                'recipes.status',
                'recipes.image',
                'cook_books.id',
                'cook_books.reaction',
                'cook_books.published_at',
            )
            ->get();
        $user = User::find($userId);

        $allBooks = DB::table('recipes')
        ->leftJoin('cook_books', 'recipes.id', '=', 'cook_books.recipe_id')
        ->leftJoin('comments', 'cook_books.id', '=', 'comments.cook_book_id')
        ->leftJoin('ratings', 'cook_books.id', '=', 'ratings.cook_book_id')
        ->leftJoin('users','recipes.user_id','=','users.id')
        ->select(
            'recipes.id as recipe_id',
            'recipes.title',
            'recipes.description',
            'recipes.difficulty',
            'recipes.time_taken',
            'recipes.status',
            'recipes.image',
            'cook_books.id as cook_book_id',
            'cook_books.reaction',
            'cook_books.published_at',
            'users.first_name',
            'users.last_name',
            'users.image as user_image',
            DB::raw('COUNT(DISTINCT comments.id) as comments_count'),
            DB::raw('AVG(ratings.rating) as average_rating')
        )
        ->whereNotNull('cook_books.published_at')
        ->where('recipes.user_id', '!=', $userId)
        ->where('recipes.status','=','approved')
        ->groupBy(
            'recipes.id',
            'recipes.title',
            'recipes.description',
            'recipes.difficulty',
            'recipes.time_taken',
            'recipes.status',
            'recipes.image',
            'cook_books.id',
            'cook_books.reaction',
            'cook_books.published_at',
            'users.first_name',
            'users.last_name',
            'users.image'
        )
        ->get();
        return view('user.cook_book', compact('userCookBooks', 'user','allBooks'));
    }


}
