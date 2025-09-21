<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Recipe;
use App\Models\Comment;
use App\Models\CookBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function store(Request $request)
    {
         $request->validate([
            'book_id' => 'required|exists:cook_books,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = Rating::create([
            'cook_book_id' => $request->book_id,
            'rating' => $request->rating,
        ]);

        return response()->json(['message' => 'Rating saved!', 'data' => $rating]);
    }

    public function addLove(Request $request){
        $request->validate([
            'book_id' => 'required|exists:cook_books,id',
        ]);

        $cookBook = CookBook::findOrFail($request->book_id);

        $cookBook->increment('reaction');

        return response()->json([
            'message' => 'Loved!',
        ]);
    }

    public function storeComment(Request $request){
        $request->validate([
            'cook_book_id' => 'required|exists:cook_books,id',
            'comment' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'cook_book_id' => $request->cook_book_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Comment posted successfully!',
        ]);
    }
    // public function filter(Request $request)
    // {
    //     $query = Recipe::with('preferences')
    //         ->join('cuisines', 'recipes.cuisine_id', '=', 'cuisines.id')
    //         ->where('recipes.status', '=', 'approved')
    //         ->select('recipes.*', 'cuisines.name as cuisine_name');

    //     if ($request->difficulty) {
    //         $query->whereIn('difficulty', $request->difficulty);
    //     }

    //     if ($request->preferences) {
    //         $query->whereHas('preferences', function ($q) use ($request) {
    //             $q->whereIn('preferences.name', $request->preferences);
    //         });
    //     }

    //     $recipes = $query->paginate(6)->appends($request->all());;

    //     // Preserve all query parameters for pagination links
    //     // $recipes->appends($request->all());

    //     // $html = view('partials.recipe_list', compact('recipes'))->render();

    //     return response()->json(['recipes' => $recipes,
    //      'links' => (string) $recipes->links()]);
    // }
    public function filter(Request $request)
    {
        $query = Recipe::with('preferences')
            ->join('cuisines', 'recipes.cuisine_id', '=', 'cuisines.id')
            ->where('recipes.status', '=', 'approved')
            ->select('recipes.*', 'cuisines.name as cuisine_name');

        if ($request->difficulty) {
            $query->whereIn('difficulty', $request->difficulty);
        }

        if ($request->preferences) {
            $query->whereHas('preferences', function ($q) use ($request) {
                $q->whereIn('preferences.name', $request->preferences);
            });
        }

        $recipes = $query->paginate(6);

        // Preserve all query parameters for pagination links
        $recipes->appends($request->all());

        $html = view('partials.recipe_list', compact('recipes'))->render();

        return response()->json(['html' => $html]);
    }


}
