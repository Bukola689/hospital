<?php

use App\Http\Controllers\Admin\NurseController;

use Illuminate\Support\Facades\Route;


   Route::get('/nurses', [NurseController::class, 'index']);
   Route::post('/nurses', [NurseController::class, 'store']);
   Route::get('/nurses/{nurse}', [NurseController::class, 'show']);
   Route::put('/nurses/{nurse}', [NurseController::class, 'update']);
   Route::DELETE('/nurses/{nurse}', [NurseController::class, 'destroy']);
   Route::get('/nurses/{search}', [NurseController::class, 'searchPost']);
    
   Route::get('search-nurses/{search}', [NurseController::class, 'search']);
