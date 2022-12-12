<?php

use App\Http\Controllers\Auth\PatientController;

use Illuminate\Support\Facades\Route;


   Route::get('/patients', [PatientController::class, 'index']);
   Route::post('/patients', [PatientController::class, 'store']);
   Route::get('/patients/{patient}', [PatientController::class, 'show']);
   Route::put('/patients/{patient}', [PatientController::class, 'update']);
   Route::DELETE('/patients/{patient}', [PatientController::class, 'destroy']);
   Route::get('/patients/{search}', [PatientController::class, 'searchPost']);
   
   Route::get('search-patients/{search}', [PatientController::class, 'search']);
