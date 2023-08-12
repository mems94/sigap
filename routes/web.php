<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Models\Employee;

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

Route::get('/', [HomeController::class, 'login'])->middleware('guest');

Route::prefix('editor')->name('editor.')->middleware('auth')->group(function() {
    Route::resource('employee', EmployeeController::class);
    Route::get('/contracts_list/{contract}', [EmployeeController::class, 'listContracts'])->name('contracts.list');
    Route::get('/print', [EmployeeController::class, 'print'])->name('print');
    Route::get('/print_all', [EmployeeController::class, 'printAll'])->name('print_all');
});

Auth::routes();

Route::get('/registration', [HomeController::class, 'create'])->name('registration');
Route::get('/users', [HomeController::class, 'index'])->name('users');
Route::delete('/delete_user', [HomeController::class, 'delete'])->name('delete_user');

