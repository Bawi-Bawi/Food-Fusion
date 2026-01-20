<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Recipe;
use App\Models\Contact;
use App\Models\Resources;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    //home page
    public function index(){
        $recipes = Recipe::limit(4)
        ->orderBy('view_count','desc')
        ->where('status','approved')
        ->get();

        $byCuisines = Recipe::join('cuisines', 'recipes.cuisine_id', '=', 'cuisines.id')
        ->where('recipes.status', '=', 'approved')
        ->whereRaw('recipes.id IN (
            SELECT MAX(id)
            FROM recipes
            WHERE status = "approved"
            GROUP BY cuisine_id
        )')
        ->select('recipes.*', 'cuisines.name as cuisine_name')
        ->get();
        $events = Event::get();
        return view('user.home',compact('recipes','byCuisines','events'));
    }

    //profile information
    public function profileInformation($id){
        $user = User::findOrFail($id);
        return view('user.profile.profile_information',compact('user'));
    }

    //update profile page
    public function updateProfilePage($id){
        $user = User::findOrFail($id);
        return view('user.profile.updateProfile',compact('user'));
    }

    //update profile
    public function updateProfile(Request $request, $id){
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $user = User::findOrFail($id);
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $oldImage = $user->image;
        if ($request->hasFile('image')) {
            if ($oldImage) {
                // Delete the old image if it exists
                Storage::disk('public')->delete('user/' . $oldImage);
            }
            $image = $request->file('image');
            $imageName = uniqid() . '_' . $image->getClientOriginalName();
            $image->storeAs('user', $imageName, 'public');
            $user->image = $imageName;
        }

        $user->save();

        return redirect()->route('profile#information', ['id' => $id])->with('success', 'Profile updated successfully!');
    }
    //about us page
    public function aboutUs(){
        return view('user.about_us');
    }
    //contact us page
    public function contactUs(){
        return view('user.contact_us');
    }

    //legal information page
    public function legalInformation(){
        return view('user.legal_information');
    }
    //culinary resources page
    public function resources($name){
        if( request('filter') !== null){
            //filter resources
            if (request('filter') === 'video') {
            $resources = Resources::whereNotNull('link')->where('type',$name)->get();
            } elseif (request('filter') === 'pdf') {
                $resources = Resources::whereNotNull('file_path')->where('type',$name)->get();
            } elseif (request('filter') === 'infographic') {
                $resources = Resources::whereNotNull('image')->whereNull('file_path')->whereNull('link')->where('type',$name)->get();
            }  else {
                $resources = Resources::where('type',$name)->get();
            }
        } else{
            //search resources
            $resources = Resources::when(request('search'),function($query){
                return $query->orWhere('title','LIKE','%'.request('search').'%');
            })->where('type',$name)->get();
        }
        $resources_page = strtolower(str_replace(" ", "_", $name));

        return view('user.'.$resources_page,compact('resources'));
    }

    //contact
    public function contact(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'inquiry_type' => 'required',
            'subject'=> 'required|max:255',
            'message'=> 'required|min:10'
        ]);
        Contact::create([
            'name' =>$request->name,
            'email' => $request->email,
            'inquiry_type'=> $request->inquiry_type,
            'subject'=> $request->subject,
            'message'=> $request->message
        ]);
    return redirect()->route('home#page')->with(['success'=>'Message sent successfully!']);
    }
    //change password page
    public function changePasswordPage($id){
        $user = User::findOrFail($id);
        return view('user.profile.changePassword',compact('user'));
    }
    //change password
    public function changePassword(Request $request, $id){
        $data = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|different:old_password',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = User::findOrFail($id);
        if (Hash::check($data['old_password'], $user->password)) {
            // Old password matches, update to new password
            $user->password = Hash::make($data['new_password']);
            $user->save();
            return redirect()->route('profile#information', ['id' => $id])->with('success', 'Password changed successfully!');
        } else {
            // Old password does not match
            return back()->withErrors(['old_password' => 'The provided password does not match your current password.']);
        }
    }
}
