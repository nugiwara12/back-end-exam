<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

// USER ROUTES
Route::prefix('users')->group(function () {
    Route::get('/userDetails', [UserManagementController::class, 'userDetails']);
    Route::post('/AddUser', [UserManagementController::class, 'AddUser']);
    Route::put('/UpdateUser/{id}', [UserManagementController::class, 'UpdateUser']);
    Route::delete('/deleteUser/{id}', [UserManagementController::class, 'deleteUser']);
    Route::patch('/restoreUser/{id}', [UserManagementController::class, 'restoreUser']);
});

// EVENT ROUTES
Route::prefix('events')->group(function () {
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/getEvent/{id}', [EventController::class, 'getEvent']);
    Route::post('/addEvent', [EventController::class, 'addEvent']);
    Route::put('/updateEvent/{id}', [EventController::class, 'updateEvent']);
    Route::delete('/destroyEvent/{id}', [EventController::class, 'destroyEvent']);
    // TICKET ROUTES under events
    Route::post('/addTicket/{event_id}', [TicketController::class, 'addTicket']);
});

// TICKET ROUTES
Route::prefix('tickets')->group(function () {
    Route::get('/getTickets', [TicketController::class, 'getTickets']);
    Route::get('/getTicket/{id}', [TicketController::class, 'getTicket']);
    Route::put('/updateTicket/{id}', [TicketController::class, 'updateTicket']);
    Route::delete('/destroyTicket/{id}', [TicketController::class, 'destroyTicket']);
    // BOOKING from ticket
    Route::post('/addBooking/{ticket_id}', [BookingController::class, 'addBooking']);
});

// BOOKING ROUTES
Route::prefix('bookings')->group(function () {
    Route::get('/getBookings', [BookingController::class, 'getBookings']);
    Route::get('/getBooking/{id}', [BookingController::class, 'getBooking']);
    Route::put('/cancelBooking/{id}', [BookingController::class, 'cancelBooking']);
    // PAYMENT
    Route::post('/addPayment/{booking_id}', [PaymentController::class, 'addPayment']);
});

// PAYMENT ROUTES
Route::prefix('payments')->group(function () {
    Route::get('/getPayment/{id}', [PaymentController::class, 'getPayment']);
});
