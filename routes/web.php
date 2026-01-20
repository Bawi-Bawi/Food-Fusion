<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
use Illuminate\Container\Attributes\Log;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CookBookController;
use App\Http\Middleware\OTPMiddleware;

Route::get('/', function () {
    return redirect()->route('home#page');
});
Route::get('/home',[HomeController::class,'index'])->name('home#page');

Route::get('/register',function(){
    return abort(404);
});
Route::get('/login',function(){
    return redirect()->route('home#page');
})->name('login');
Route::get('/logout', function () {
    return abort(404);
});

Route::post('/register', [AuthController::class, 'register'])->name('account#register');
//email verification
Route::middleware([
    OTPMiddleware::class
])->group(function(){
    Route::get('/verify-email', fn () => view('emails.otp'))
        ->name('verify#email#form');
    Route::post('/verify-email', [AuthController::class, 'verifyEmail'])
        ->name('verify#email');
});

//login and logout
Route::post('/login', [AuthController::class, 'login'])->name('account#login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('account#logout');
// admin
Route::middleware([
    'auth',
    RoleMiddleware::class
])->group(function () {
    Route::get('/dashboard',[AdminController::class, 'dashboard'])->name('admin#dashboard');
    Route::delete('/user/delete/{id}',[AdminController::class,'deleteUser'])->name('user#delete');
    Route::get('/recipes/list',[AdminController::class,'recipesList'])->name('recipes#list');
    Route::get('/recipe/admin/details/{id}',[AdminController::class,'recipeDetails'])->name('recipe#adminDetails');
    Route::post('/recipe/change/status/{id}',[AdminController::class,'updateStatus'])->name('recipe#updateStatus');
    Route::get('/resources',[AdminController::class,'resources'])->name('admin#resources');
    Route::delete('/resources/delete/{id}',[AdminController::class,'deleteResource'])->name('admin#deleteResource');
    Route::get('video/resources',[AdminController::class,'addVideo'])->name('video#resources');
    Route::get('pdf/resources',[AdminController::class,'addPdf'])->name('pdf#resources');
    Route::post('add/video/resources',[AdminController::class,'addVideoResources'])->name('add#videoResources');
    Route::post('add/pdf/resources',[AdminController::class,'addPdfResources'])->name('add#pdfResources');
    Route::get('/infographic/resources',[AdminController::class,'infographicResources'])->name('infographic#resources');
    Route::post('add/infographic/resources',[AdminController::class,'addInfographicResources'])->name('add#infographicResources');
    Route::get('events/list',[AdminController::class,'eventList'])->name('event#list');
    Route::get('add/event',[AdminController::class,'addEventPage'])->name('event#addPage');
    Route::post('add/event',[AdminController::class,'addEvent'])->name('event#add');
    Route::delete('/event/delete/{id}',[AdminController::class,'deleteEvent'])->name('event#delete');
    Route::get('event/edit/{id}',[AdminController::class,'eventEditPage'])->name('event#editPage');
    Route::post('event/edit/{id}',[AdminController::class,'eventEdit'])->name('event#edit');
    Route::get('contact/list',[AdminController::class,'contactList'])->name('contact#list');
    Route::get('contact/details/{id}',[AdminController::class,'contactDetails'])->name('contact#details');
    Route::delete('contact/delete/{id}',[AdminController::class,'contactDelete'])->name('contact#delete');
});

//user
Route::get('/cook_book',[CookBookController::class, 'index'])->name('cook_book#page');
Route::get('recipe/add',[RecipeController::class, 'addPage'])->name('recipe#addPage');
Route::get('recipe/details/{id}',[RecipeController::class,'recipeDetails'])->name('recipe#details');
Route::post('/rate',[AjaxController::class,'store']);
Route::post('/love',[AjaxController::class,'addLove']);
Route::get('/recipes/collection',[RecipeController::class,'collection'])->name('recipes#collection');
Route::get('/recipes/filter', [RecipeController::class, 'filter'])->name('recipes#filter');
Route::get('/about/us/',[HomeController::class,'aboutUs'])->name('about#us');
Route::get('/contact/us/',[HomeController::class,'contactUs'])->name('contact#us');
Route::get('/legal/information', [HomeController::class, 'legalInformation'])->name('legal#information');
Route::get('/resources/{name}', [HomeController::class, 'resources'])->name('resources');
Route::post('/contact',[HomeController::class,'contact'])->name('user#contact');

Route::middleware([
    'auth',
])->group(function () {
    Route::post('recipe/add',[RecipeController::class, 'addRecipe'])->name('recipe#addRecipe');
    Route::get('ingredient/add/{id}',[RecipeController::class,'addIngredientPage'])->name('ingredient#addPage');
    Route::post('ingredient/add/{id}',[RecipeController::class,'addIngredient'])->name('ingredient#addIngredient');
    Route::post('/add-comment',[AjaxController::class,'storeComment']);
    Route::delete('/recipe/delete/{id}',[RecipeController::class,'delete'])->name('recipe#delete');
    //user profile
    Route::get('/profile/information/{id}',[HomeController::class,'profileInformation'])->name('profile#information');
    Route::get('/profile/update/{id}',[HomeController::class,'updateProfilePage'])->name('profile#updatePage');
    Route::post('/profile/update/{id}',[HomeController::class,'updateProfile'])->name('profile#update');
    Route::get('/change/password/{id}',[HomeController::class,'changePasswordPage'])->name('change#passwordPage');
    Route::post('/change/password/{id}',[HomeController::class,'changePassword'])->name('change#password');
});
