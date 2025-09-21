<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Comment;
use App\Models\Cuisine;
use App\Models\Category;
use App\Models\CookBook;
use App\Models\Sections;
use App\Models\Directions;
use App\Models\Preference;
use App\Models\Ingredients;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{

    // add recipe page
    public function addPage()
    {
        if(Auth::user() == null) {
            return redirect()->route('home#page')->with('error', 'You must be logged in to add a recipe.');
        }
        $preferences = Preference::get();
        return view('user.addRecipe',compact('preferences'));
    }

    // add recipe
    public function addRecipe(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'cuisine' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'preference' => 'required|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $title = ucwords(strtolower(trim($validated['title'])));
        $categoryName = ucwords(strtolower(trim($validated['category'])));
        $cuisineName = ucwords(strtolower(trim($validated['cuisine'])));

        $category = Category::firstOrCreate(['name' => $categoryName]);
        $cuisine = Cuisine::firstOrCreate(['name' => $cuisineName]);

        $image = $request->file('image');
        $imageName = uniqid() . '_' . $image->getClientOriginalName();
        $image->storeAs('Recipes', $imageName, 'public');

        $recipe = Recipe::create([
            'user_id' => Auth::id(),
            'cuisine_id' => $cuisine->id,
            'category_id' => $category->id,
            'title' => $title,
            'description' => $validated['description'],
            'image' => $imageName,
        ]);

        $recipe->preferences()->attach($validated['preference']);

        return redirect()->route('ingredient#addPage', ['id' => $recipe->id]);
    }

    // add ingredient page
    public function addIngredientPage($recipeId)
    {
        $recipe = Recipe::findOrFail($recipeId);
        if (Auth::user() == null || Auth::user()->id != $recipe->user_id) {
            return redirect()->route('home#page')->with('error', 'You must be the author to add ingredients to this recipe.');
        }
        return view('user.addIngredient', compact('recipe'));
    }

    // add ingredient
    public function addIngredient(Request $request,$recipeId)
    {
        $request->validate([
            'difficulty' => 'required|string|max:255',
            'timeTaken' => 'required|string|max:255',
            'ingredients' => 'required|string',
            'directions' => 'required|string',
        ]);
        $input = $request->ingredients;
        $lines = array_filter(array_map('trim', explode("\n", $input)));
        $ingredients = [];
        $currentSection = null;
        $hasPrepareSection = false;
        foreach ($lines as $line) {
            if (preg_match('/^Prepare [A-Za-z ]+:$/', $line)) {
                // Found a new "Prepare Something:" section
                $currentSection = rtrim($line, ':');
                $ingredients[$currentSection] = [];
                $hasPrepareSection = true;
            } elseif (strpos($line, '-') === 0) {
                // Ingredient line
                if ($currentSection === null) {
                    // No section yet, use default
                    $currentSection = 'Ingredients';
                    $ingredients[$currentSection] = [];
                }
                $ingredients[$currentSection][] = $line;
            }
        }

        $inputDirections = $request->directions;
        $lines = array_filter(array_map('trim', explode("\n", $inputDirections)));
        $directions = [];
        $currentSection = null;

        foreach ($lines as $line) {
            if (preg_match('/^Prepare [A-Za-z ]+:$/', $line)) {
                $currentSection = rtrim($line, ':');
                $directions[$currentSection] = [];
            } else {
                if ($currentSection === null) {
                    $currentSection = 'Ingredients';
                    $directions[$currentSection] = [];
                }
                $directions[$currentSection][] = $line;
            }
        }
        foreach ($ingredients as $sectionTitle => $items) {
            $sections = Sections::create([
                'recipe_id' => $recipeId,
                'title' => $sectionTitle,
            ]);

            foreach ($items as $ingredientLine) {
                $sections->ingredients()->create([
                    'ingredient' => $ingredientLine,
                ]);
            }
            if (isset($directions[$sectionTitle])) {
                foreach ($directions[$sectionTitle] as $instructionLine) {
                    $sections->directions()->create([
                        'direction' => $instructionLine,
                    ]);
                }
            }

        }
        Recipe::where('id', $recipeId)->update([
            'difficulty' => $request->difficulty,
            'time_taken' => $request->timeTaken

        ]);
        CookBook::create([
            'recipe_id' => $recipeId,
            'published_at' =>Carbon::now(),
        ]);

        return redirect()->route('cook_book#page')->with('success', 'Recipe added successfully.Wait for admin approval.');
    }
    //recipe details
    public function recipeDetails($recipeId){
        $recipe = Recipe::where('id',$recipeId)->first();
        $recipe->increment('view_count');
        $book = CookBook::where('recipe_id',$recipeId)->first();
        $sections = Sections::where('recipe_id',$recipeId)->get();
        foreach($sections as $section){
            $ingredients = Ingredients::where('section_id',$section->id)->get();
            $directions = Directions::where('section_id',$section->id)->get();
        }
        $hasPreparation = false;
        if(count($sections) >= 2){
            $hasPreparation = true;
        }
        $user = User::select('first_name','last_name')->where('id',$recipe->user_id)->first();
        $comments = Comment::where('cook_book_id', $book->id)
           ->with('user')
           ->orderBy('id','desc')
           ->get();

        return view('user.recipeDetails',compact('recipe','sections','ingredients','directions','hasPreparation','user','book','comments'));
    }

    //delete recipe
    public function delete($recipeId){
        $recipe = Recipe::findOrFail($recipeId);
        $dbImageName = $recipe->image;

        if( $dbImageName !== null){
            Storage::disk('public')->delete('Recipes/'.$dbImageName);
        }
        Recipe::where('id',$recipeId)->delete();
        if(Auth::user()->role == 'admin'){
            return redirect()->route('recipes#list')->with('success', 'Recipe delete successfully!');
        }
        return redirect()->route('cook_book#page')->with('success', 'Recipe delete successfully!');
    }

    //recipe collection
    public function collection(){
        //search by category
        if(request('categoryId')){
            $recipes = Recipe::with('preferences') // load preferences relationship
            ->join('cuisines', 'recipes.cuisine_id', '=', 'cuisines.id')
            ->where('recipes.category_id', request('categoryId'))
            ->where('recipes.status', '=', 'approved')
            ->select('recipes.*', 'cuisines.name as cuisine_name')
            ->paginate(6);
        }  else{ // search by recipe or cuisine type
            $recipes = Recipe::with('preferences')
            ->join('cuisines', 'recipes.cuisine_id', '=', 'cuisines.id')
            ->when(request('search'), function ($query) {
                $search = request('search');
                return $query->where(function($q) use ($search) {
                    $q->where('recipes.title', 'LIKE', "%{$search}%")
                      ->orWhere('cuisines.name', 'LIKE', "%{$search}%");
                });
            })
            ->where('recipes.status', '=', 'approved')
            ->select('recipes.*', 'cuisines.name as cuisine_name')
            ->paginate(6);
        }
        $recipes->appends(request()->all());
        $categories = Category::get();
        $preferences = Preference::all();
        return view('user.recipes_collection', compact('recipes','categories','preferences'));
    }
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
