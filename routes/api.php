<?php

use App\Http\Controllers\Api\InstitutionController;
use App\Http\Controllers\Api\LocationController;
use Illuminate\Support\Facades\Route;

Route::apiResource('institutions', InstitutionController::class);
Route::apiResource('locations', LocationController::class);
