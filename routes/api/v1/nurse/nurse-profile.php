<?php

use App\Http\Controllers\Nurse\NurseProfileController;

use Illuminate\Support\Facades\Route;

Route::post('/nurse-profiles', [NurseProfileController::class, 'nurseProfile']);
Route::get('my-profile', [NurseProfileController::class, 'singleNurse']);



