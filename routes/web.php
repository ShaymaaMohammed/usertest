<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminMiddleware;


/*Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::post('updatepassword', [UserController::class, 'updatePassword'])->name('update_password');
    });*/


Route::get('/', function () {
    return view('welcome');
});


Route::get('/users', [UserController::class, 
'list'])->name('users_list');

Route::get('users/admin_edit/{user?}', [UserController::class, 'admin_edit'])->name('admin_users_edit');
Route::post('users/admin_save/{user}', [UserController::class, 'admin_save'])->name('users_save');

Route::get('users/personal_information/{user?}', [UserController::class, 'personal_information'])->name('personal_information_edit');
Route::post('users/admin_save/{user}', [UserController::class, 'information_save'])->name('information_save');

Route::get('users/add/{user?}', [UserController::class, 
'new'])->name('user_new');
Route::post('user/save/{user?}', [UserController::class, 
'save'])->name('user_save');

Route::get('users/delete/{user}', [UserController::class, 
'delete'])->name('user_delete');

Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('user_edit');
Route::post('/users/update/{user}', [UserController::class, 'update'])->name('user_update');

Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'doRegister'])->name('do_register');

Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'doLogin'])->name('do_login');

Route::get('logout', [UserController::class, 'doLogout'])->name('do_logout');

Route::get('profile', [UserController::class, 'profile'])->name('profile');
Route::post('updatepassword', [UserController::class, 'updatePassword'])->name('update_password');
