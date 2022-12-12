<?php

use App\Http\Controllers\Admin\ServiceController;

use Illuminate\Support\Facades\Route;


   Route::get('/services', [ServiceController::class, 'index']);
   Route::post('/services', [ServiceController::class, 'store']);
   Route::get('/services/{service}', [ServiceController::class, 'show']);
   Route::put('/services/{service}', [ServiceController::class, 'update']);
   Route::DELETE('/services/{service}', [ServiceController::class, 'destroy']);
   Route::get('/services/{search}', [ServiceController::class, 'searchPost']);
   
   Route::get('search-services/{search}', [ServiceController::class, 'search']);
