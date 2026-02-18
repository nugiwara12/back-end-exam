<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\OrganizerMiddleware;
use App\Http\Middleware\CustomerMiddleware;

Route::middleware(['auth:sanctum', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/events', [EventController::class, 'index']);           
    Route::get('/events/{id}', [EventController::class, 'getEvent']);  
    Route::post('/events', [EventController::class, 'addEvent']);       
    Route::put('/events/{id}', [EventController::class, 'updateEvent']);
    Route::delete('/events/{id}', [EventController::class, 'destroyEvent']);
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