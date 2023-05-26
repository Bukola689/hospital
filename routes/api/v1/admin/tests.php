<?php

use App\Http\Controllers\Admin\TestController;

use Illuminate\Support\Facades\Route;


Route::get('tests', [TestController::class, 'index']);
Route::get('remove-tests/{test}', [TestController::class, 'removeTest']);
Route::get('status/{test}', [TestController::class, 'updateTest']);


