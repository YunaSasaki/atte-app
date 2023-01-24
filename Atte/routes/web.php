<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StampController;
use App\Http\Controllers\RestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;

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

Route::get('/', [ViewController::class, 'home'])->middleware(['auth', 'verified'])->name('home');
Route::get('/attendance', [ViewController::class, 'attendance'])->middleware(['auth', 'verified'])->name('attendance');
Route::post('/work/start', [StampController::class, 'start']);
Route::post('/work/end', [StampController::class, 'end']);
Route::post('/rest/start', [RestController::class, 'start']);
Route::post('/rest/end', [RestController::class, 'end']);

require __DIR__.'/auth.php';