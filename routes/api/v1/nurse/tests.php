<?php

use App\Http\Controllers\Nurse\TestController;

use Illuminate\Support\Facades\Route;

Route::post('save-tests', [TestController::class, 'storeTest']);
Route::get('my-test', [TestController::class, 'getTestId']);



