<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;
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

// routes/web.php
Route::group(['middleware' => 'check.install'], function () {
    Route::get('/install', [InstallController::class, 'welcome']);
    Route::get('/install/requirements', [InstallController::class, 'requirements']);
    Route::get('/install/env', [InstallController::class, 'envForm']);
    Route::post('/install/env', [InstallController::class, 'saveEnv']);
    Route::get('/install/database', [InstallController::class, 'dbSetup']);
    Route::post('/install/admin', [InstallController::class, 'createAdmin']);
    Route::get('/install/finish', [InstallController::class, 'finish']);
});

