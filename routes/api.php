<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\EventController;

// public routes
Route::prefix('users')->group(function () {
    Route::get('/userDetails', [UserManagementController::class, 'userDetails']);
    Route::post('/AddUser', [UserManagementController::class, 'AddUser']);
    Route::put('/UpdateUser/{id}', [UserManagementController::class, 'UpdateUser']);
    Route::delete('/deleteUser/{id}', [UserManagementController::class, 'deleteUser']);
    Route::patch('/restoreUser/{id}', [UserManagementController::class, 'restoreUser']);
});

Route::prefix('events')->group(function () {
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/getEvent/{id}', [EventController::class, 'getEvent']);
    Route::post('/addEvent', [EventController::class, 'addEvent']);
    Route::put('/updateEvent/{id}', [EventController::class, 'updateEvent']);
    Route::delete('/destroyEvent/{id}', [EventController::class, 'destroyEvent']);
});

