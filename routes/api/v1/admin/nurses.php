<?php

use App\Http\Controllers\Admin\NurseController;

use Illuminate\Support\Facades\Route;


   Route::get('/nurses', [NurseController::class, 'index']);
   Route::get('/nurses/{nurse}', [NurseController::class, 'show']);
   Route::post('/nurses', [NurseController::class, 'store']);
   Route::put('/nurses/{nurse}', [NurseController::class, 'update']);
   Route::DELETE('/nurses/{nurse}', [NurseController::class, 'destroy']);
   Route::get('search-nurses/{search}', [NurseController::class, 'search']);
