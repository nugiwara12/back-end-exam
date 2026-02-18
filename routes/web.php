<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\CustomerController;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\OrganizerMiddleware;
use App\Http\Middleware\CustomerMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
// require __DIR__.'/api.php';

Route::middleware(['auth:sanctum', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/events', [EventController::class, 'index']);           
    Route::get('/getEvent/{id}', [EventController::class, 'getEvent']);  
    Route::post('/addEvent', [EventController::class, 'addEvent']);       
    Route::put('/updateEvent/{id}', [EventController::class, 'updateEvent']);
    Route::delete('/destroyEvent/{id}', [EventController::class, 'destroyEvent']);
});

Route::middleware(['auth:sanctum', OrganizerMiddleware::class])->prefix('organizer')->group(function () {
    Route::get('/organizer', [OrganizerController::class, 'index']);
    Route::get('/displayOrgEvent/{id}', [OrganizerController::class, 'displayOrgEvent']);
    Route::post('/addOrgEvent', [OrganizerController::class, 'addOrgEvent']);
    Route::put('/updateOrgEvent/{id}', [OrganizerController::class, 'updateOrgEvent']);
    Route::delete('/destroyOrgEvent/{id}', [OrganizerController::class, 'destroyOrgEvent']);
});

Route::middleware(['auth:sanctum', CustomerMiddleware::class])->prefix('customer')->group(function () {
    Route::post('/bookings', [CustomerController::class, 'bookTicket']);
    Route::get('/myBookings', [CustomerController::class, 'myBookings']);
});

