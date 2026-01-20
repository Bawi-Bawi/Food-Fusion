<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Recipe;
use App\Models\Contact;
use App\Models\Sections;
use App\Models\Resources;
use App\Models\Directions;
use App\Models\Ingredients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
     //admin dashboard
    public function dashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
             $users = User::when(request('table_search'),function($query){
                return $query->orWhere('first_name','LIKE','%'.request('table_search').'%')
                                ->orWhere('last_name','LIKE','%'.request('table_search').'%')
                             ->orWhere('email','LIKE','%'.request('table_search').'%');
            })->paginate(5);
            $users->appends(request()->all());
            return view('admin.dashboard',compact('users'));
        }
        return redirect('/home');
    }

    // delete user
    public function deleteUser($id){
        Recipe::where('user_id',$id)->delete();
        User::where('id',$id)->delete();
        return redirect()->route('admin#dashboard')->with('success', 'User deleted successfully.');
    }
   // recipes list page
   public function recipesList(){
    $recipes = Recipe::when(request('table_search'),function($query){
        return $query->orWhere('title','LIKE','%'.request('table_search').'%');

    })->orderBy('id','desc')
    ->paginate(5);
    $recipes->appends(request()->all());
    return view('admin.recipeList',compact('recipes'));
   }

   //recipe details
   public function recipeDetails($recipeId){
    $recipe = DB::table('recipes')
    ->leftJoin('cook_books', 'recipes.id', '=', 'cook_books.recipe_id')
    ->leftJoin('categories','categories.id','=','recipes.category_id')
    ->leftJoin('cuisines','cuisines.id','=','recipes.cuisine_id')
    ->leftJoin('users','users.id','=','recipes.user_id')
    ->select(
    'recipes.*',
    'cook_books.published_at',
    'categories.name as category_name',
    'cuisines.name as cuisine_name',
    'users.first_name',
    'users.last_name',
    'users.email'
    )
    ->where('recipes.id',$recipeId)
    ->first();

    $sections = Sections::where('recipe_id',$recipeId)->get();
    $hasPreparation = false;
    if(count($sections) >= 2){
        $hasPreparation = true;
    }
    $ingredients = [];
    $directions = [];
    foreach($sections as $section){
        $ingredients = Ingredients::where('section_id',$section->id)->get();
        $directions = Directions::where('section_id',$section->id)->get();
    }
    return view('admin.recipeDetails',compact('recipe','sections','ingredients','directions','hasPreparation'));
   }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $recipe = Recipe::findOrFail($id);
        $recipe->status = $request->status;
        $recipe->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

    public function resources(){
        $resources = Resources::when(request('table_search'),function($query){
            return $query->orWhere('title','LIKE','%'.request('table_search').'%');

        })->orderBy('id','desc')
        ->paginate(10);
        $resources->appends(request()->all());
        return view('Admin.resources',compact('resources'));
    }

    public function addVideo(){
        return view('Admin.Resources.addVideo');
    }
    public function addPdf(){
        return view('Admin.Resources.addPdf');
    }
    public function addVideoResources(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'resource_type' => 'required|in:Culinary Resources,Education Resources',
            'video_url' => 'required|url'
        ]);
        Resources::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->resource_type,
            'link' => $request->video_url
        ]);

        return redirect()->route('admin#resources')->with('success', 'Video resource added successfully.');
    }

    public function deleteResource($id){
        $resource = Resources::findOrFail($id);

        if($resource->image && $resource->file_path){
            Storage::disk('public')->delete('image/'.$resource->image);
            Storage::disk('public')->delete('file/'.$resource->file_path);
        } elseif($resource->file_path == null){
            Storage::disk('public')->delete('image/'.$resource->image);
        }
        $resource->delete();
        return redirect()->route('admin#resources')->with('success', 'Resource deleted successfully.');
    }

    public function addPdfResources(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'resource_type' => 'required|in:Culinary Resources,Educational Resources',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'file_name' => 'required|mimes:pdf|max:10000'
        ]);


        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->storeAs('image', $imageName, 'public');
        } else {
            $imageName = null;
        }

        // Handle file upload
        if ($request->hasFile('file_name')) {
            $file = $request->file('file_name');
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            $file->storeAs('file', $fileName, 'public');
        } else {
            $fileName = null;
        }

        Resources::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->resource_type,
            'image' => $imageName,
            'file_path' => $fileName
        ]);

        return redirect()->route('admin#resources')->with('success', 'PDF resource added successfully.');
    }

    public function infographicResources(){
        return view('Admin.Resources.addInfographic');
    }
    public function addInfographicResources(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);
        // // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->storeAs('image', $imageName, 'public');
        } else {
            $imageName = null;
        }

        Resources::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'image' => $imageName,
            'file_path' => null,
            'link' => null
        ]);

        return redirect()->route('admin#resources')->with('success', 'Infographic resource added successfully.');
    }

    //event list page
    public function eventList(){
        $events = Event::when(request('table_search'),function($query){
            return $query->orWhere('name','LIKE','%'.request('table_search').'%');

        })->orderBy('id','desc')
        ->paginate(5);
        $events->appends(request()->all());
        return view('Admin.Event.list',compact('events'));
    }

    public function addEventPage(){
        return view('admin.event.add');
    }

    public function addEvent(Request $request){
        $this->validateRequest($request);
        $dateTime = Carbon::createFromFormat('Y-m-d\TH:i', $request['date']);
        $image = $request->file('image');
        $imageName = uniqid() . '_' . $image->getClientOriginalName();
        $image->storeAs('event', $imageName, 'public');
        Event::create([
            'name' => $request->title,
            'image'=> $imageName,
            'date'=> $dateTime,
            'location'=> $request->location
        ]);
        return redirect()->route('event#list')->with(['success'=> 'Add Event Successfully']);
    }

    //event details
    public function eventEditPage($id){
        $event = Event::find($id);
        return view('admin.event.edit',compact('event'));
    }
    //edit event
    public function eventEdit(Request $request, $id){
        $this->validateRequest($request);
        $event = Event::find($id);
        if($event->image){
            Storage::disk('public')->delete('event/'.$event->image);
        }
        $image = $request->file('image');
        $imageName = uniqid() . '_' . $image->getClientOriginalName();
        $image->storeAs('event', $imageName, 'public');
        $dateTime = Carbon::createFromFormat('Y-m-d\TH:i', $request['date']);
        $event->update([
            'name' => $request->title,
            'image'=> $imageName,
            'date'=> $dateTime,
            'location'=> $request->location
        ]);
        return redirect()->route('event#list')->with(['success'=> 'Update Event Successfully']);
    }
    //delete event
    public function deleteEvent($id){
        $event = Event::find($id);
        if( $event->image !== null){
            Storage::disk('public')->delete('event/'.$event->image);
        }
        $event->delete();
        return redirect()->route('event#list')->with(['success'=> 'Event delete Successfully']);
    }

    //contact list
    public function contactList(){
        if(request('type') !== null){
            $contacts = Contact::where('inquiry_type',request('type'))->orderBy('created_at','desc')->paginate(5);
        }else{
            $contacts = Contact::orderBy('created_at','desc')->paginate(5);
        }
        $contacts->appends(request()->all());
        return view('admin.contact.list',compact('contacts'));
    }

    //contact details
    public function contactDetails($id){
        $contact = Contact::find($id);
        return view('admin.contact.details',compact('contact'));
    }

    //delete contact message
    public function contactDelete($id){
        Contact::where('id',$id)->delete();
        return redirect()->route('contact#list')->with(['success'=>'Message deleted successfully!']);
    }
    //validate request
    private function validateRequest($request){
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'date' => 'required|date',
            'location'=> 'required'
        ]);
    return $request;
    }

}
