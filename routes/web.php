<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing

// All Listings
Route::get('/reservations', [ListingController::class, 'index'])->middleware('auth');;
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::post('/createPost', [PostController::class, 'createPost'])->name('posts.create');;
Route::get('/landing', [UserController::class, 'show']);
Route::get('/calendar', [ListingController::class, 'calendar'])->middleware('auth');;

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');;



// Show Create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::get('/create', [PostController::class, 'create'])->middleware('auth');


Route::put('/updatePost/{id}', [PostController::class, 'update'])->middleware('auth');
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
// Store Listing Data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

// Show Edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Update Listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Delete Listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');


//Cancel Listing
Route::post('/reservations/{id}', [ListingController::class, 'cancelReservation'])->middleware('auth');



// Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// Single Listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Show Register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create New User
Route::post('/users', [UserController::class, 'store']);

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);


Route::put('/profile/{id}', [UserController::class, 'updateProfile'])->middleware('auth');

Route::get('/', function (){
    return view('landing');
});
Route::get('/about', function (){
    return view('about');
});Route::get('/terms', function (){
    return view('terms');
});
Route::get('/privacy', function (){
    return view('privacy');
});Route::get('/faq', function (){
    return view('questions');
});

//// routes/web.php
//Route::get('/api/locations', [UserController::class, 'search']);

Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('posts.like')->middleware('auth');
Route::post('/posts/{post}/unlike', [LikeController::class, 'destroy'])->name('posts.unlike')->name('posts.like')->middleware('auth');
