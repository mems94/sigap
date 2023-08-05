<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;

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
    return view('auth.login');
})->middleware('guest');

Route::prefix('editor')->name('editor.')->middleware('auth')->group(function() {
    Route::resource('employee', EmployeeController::class);
});

Auth::routes();

Route::get('/register', [HomeController::class, 'register'])->name('registration');
Route::get('/users', [HomeController::class, 'index'])->name('users');
