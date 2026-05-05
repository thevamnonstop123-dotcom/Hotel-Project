<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::resource('rooms', RoomController::class);
Route::resource('bookings', BookingController::class);
Route::resource('amenities', AmenityController::class);