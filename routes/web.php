<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Masters\ResetPasswordController;
use App\Http\Controllers\Masters\UserController;
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

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        $title = 'Login';
        return view('auth.login', compact('title'));
    });
    Route::get('/login', [LoginController::class, 'index'])->name('login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('changePassword', [ChangePasswordController::class, 'index'])->name('changePassword.index');
    Route::post('changePassword', [ChangePasswordController::class, 'update'])->name('changePassword.update');
    Route::group(['middleware' => ['role:admin|super']], function () {
        Route::group(['prefix' => 'masters', 'as' => 'masters.'], function(){
            Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
            Route::post('users/{id}/delete_forever', [UserController::class, 'delete_forever'])->name('users.delete_forever');
            Route::resource('users', UserController::class)->except('show');
            Route::post('resetPassword/{id}', [ResetPasswordController::class, 'update'])->name('resetPassword.update');
        });
    });
});
