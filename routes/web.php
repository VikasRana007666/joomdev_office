<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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


// For Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::match(['get', 'post'], 'adding_admin', [AdminController::class, 'adding_admin']);
    Route::match(['get', 'post'], 'login', [AdminController::class, 'login'])->name('login');

    Route::middleware(['adminauth'])->group(function () {
        Route::match(['get', 'post'], 'home', [AdminController::class, 'home'])->name('home');
        Route::match(['get', 'post'], 'add-user', [AdminController::class, 'add_user'])->name('add_user');
        Route::match(['get', 'post'], 'all-tasks', [AdminController::class, 'all_tasks'])->name('all_tasks');
        Route::match(['get', 'post'], 'download-csv', [AdminController::class, 'download_csv'])->name('download_csv');
        Route::match(['get', 'post'], 'logout', [AdminController::class, 'logout'])->name('logout');
    });
});

// For User
Route::prefix('user')->name('user.')->group(function () {

    Route::match(['get', 'post'], 'login', [UserController::class, 'login'])->name('login');
    Route::match(['get', 'post'], 'reset-password', [UserController::class, 'reset_password'])->name('reset_password');


    Route::middleware(['userauth'])->group(function () {
        Route::match(['get', 'post'], 'home', [UserController::class, 'home'])->name('home');
        Route::match(['get', 'post'], 'add-task', [UserController::class, 'add_task'])->name('add_task');
        Route::match(['get', 'post'], 'logout', [UserController::class, 'logout'])->name('logout');
    });
});
