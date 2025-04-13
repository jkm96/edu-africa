<?php

use App\Http\Controllers\Api\InstitutionController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\ProgramController;
use Illuminate\Support\Facades\Route;

Route::apiResource('institutions', InstitutionController::class);
Route::prefix('institutions')->group(function (){
    Route::post('submit', [InstitutionController::class, 'submit']);
    Route::get('{institution}/programs', [InstitutionController::class, 'programs']);
});

Route::apiResource('locations', LocationController::class);
Route::apiResource('programs', ProgramController::class);
