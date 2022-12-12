<?php

use App\Http\Controllers\Admin\AdminController;

use Illuminate\Support\Facades\Route;


   Route::get('/doctors', [AdminController::class, 'index']);
   Route::post('/doctors', [AdminController::class, 'store']);
   Route::get('/doctors/{doctor}', [AdminController::class, 'show']);
   Route::put('/doctors/{doctor}', [AdminController::class, 'update']);
   Route::DELETE('/doctors/{doctor}', [AdminController::class, 'destroy']);
   Route::get('/doctors/{search}', [AdminController::class, 'searchPost']);
   
   Route::get('search-doctors/{search}', [AdminController::class, 'search']);
