<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/setup', [AuthController::class, 'setup']);
Route::get('/user', [AuthController::class, 'userList']);