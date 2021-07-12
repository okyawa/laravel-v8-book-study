<?php

use App\Events\PublishProcessor;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PdfGeneratorAction;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/event', EventController::class);

Route::get('pdf', PdfGeneratorAction::class);

// Route::get('/home', function() {
//     return view('home');
// });

// Route::get('/register', [RegisterController::class, 'create']);
// Route::post('/register', [RegisterController::class, 'store']);
// Route::get('/login', [LoginController::class, 'index']);
// Route::post('/login', [LoginController::class, 'authenticate']);
// Route::get('/logout', [LoginController::class, 'logout']);

// Route::get('/eloquent', EloquentAction::class);
// Route::get('/query-builder', QueryBuilderAction::class);
