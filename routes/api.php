<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Middleware\CheckRole;

// Route::middleware(['auth:sanctum', CheckRole::class])->group(function () {
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/getEvent/{id}', [EventController::class, 'getEvent']);
    Route::post('/addEvent', [EventController::class, 'addEvent']);
    Route::put('/updateEvent/{id}', [EventController::class, 'updateEvent']);
    Route::delete('/destroyEvent/{id}', [EventController::class, 'destroyEvent']);
// });
