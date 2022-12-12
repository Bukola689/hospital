<?php

use App\Http\Controllers\Admin\RoomController;

use Illuminate\Support\Facades\Route;


   Route::get('/rooms', [RoomController::class, 'index']);
   Route::post('/rooms', [RoomController::class, 'store']);
   Route::get('/rooms/{room}', [RoomController::class, 'show']);
   Route::put('/rooms/{room}', [RoomController::class, 'update']);
   Route::DELETE('/rooms/{room}', [RoomController::class, 'destroy']);
   Route::get('/rooms/{search}', [RoomController::class, 'searchPost']);
    
   Route::get('search-rooms/{search}', [RoomController::class, 'search']);
