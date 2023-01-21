<?php

use Illuminate\Support\Facades\Auth;
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
    return redirect('/login');
})->name('home');

Route::get('/login', function() {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('auth.login');
});

//Route::middleware('auth')->group(function() {
//    Route::get('/events', function() {
//       return view('admin.events.index');
//    })->name('events.index');
//});

Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');

Route::post('logout',[\App\Http\Controllers\Auth\AuthController::class, 'logout'])->middleware('auth')->name('logout');


Route::middleware('auth')->group(function() {
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('events', [\App\Http\Controllers\Ajax\EventController::class, 'index'])->name('events.index');
    Route::get('events/ajax', [\App\Http\Controllers\Ajax\EventController::class, 'ajax'])->name('events.ajax');
    Route::post('events/store', [\App\Http\Controllers\Ajax\EventController::class, 'store'])->name('events.store');
    Route::post('events/{event}/update', [\App\Http\Controllers\Ajax\EventController::class, 'update'])->name('events.update');
    Route::post('events/{event}/destroy', [\App\Http\Controllers\Ajax\EventController::class, 'destroy'])->name('events.destroy');
});



