<?php

use App\Http\Controllers\Api\InstitutionController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\ProgramController;
use Illuminate\Support\Facades\Route;

Route::apiResource('institutions', InstitutionController::class);
Route::apiResource('locations', LocationController::class);
Route::apiResource('programs', ProgramController::class);
