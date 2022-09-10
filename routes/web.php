<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FleetController;
use App\Http\Controllers\RefuellingController;
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

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('fleets', FleetController::class);
    Route::resource('refuelling', RefuellingController::class);
});

