<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/blog',[PostsController::class,'index']); //prikazuje sve 
    Route::get('/blog/{id}',[PostsController::class,'show']); //prikazuje jedan blog iz baze
    Route::get('/blog/create/post', [PostsController::class,'create']); // prikazuje create formu
    Route::post('/blog/create/post', [PostsController::class,'store']); // cuva kreirani post u bazu
    Route::get('/blog/{id}/edit', [PostsController::class,'edit']); // prikazuje edit formu
    Route::put('/blog/{id}/edit', [PostsController::class,'update']); // cuva azurirani post u bazu
    Route::delete('/blog/{id}',[PostsController::class,'destroy']); // brise post iz baze
});

require __DIR__.'/auth.php';
