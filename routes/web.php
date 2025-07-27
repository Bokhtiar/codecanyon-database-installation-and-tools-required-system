<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\WelcomeController;
use App\Models\User;
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

Route::get('/', [WelcomeController::class, 'index']);

// routes/web.php
Route::group(['middleware' => 'check.install'], function () {
    Route::get('/install', [InstallController::class, 'welcome'])->name('install.welcome');
    Route::get('/install/requirements', [InstallController::class, 'requirements'])->name('install.requirements');
    Route::get('/install/env', [InstallController::class, 'envForm'])->name('install.env');
    Route::post('/install/env', [InstallController::class, 'saveEnv'])->name('install.saveEnv');
    Route::get('/install/database', [InstallController::class, 'dbSetup'])->name('install.database');
    Route::post('/install/admin', [InstallController::class, 'createAdmin'])->name('install.admin');
    Route::get('/install/finish', [InstallController::class, 'finish'])->name('install.finish');
});

