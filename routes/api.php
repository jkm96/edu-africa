<?php

use App\Http\Controllers\Api\InstitutionController;
use Illuminate\Support\Facades\Route;

Route::apiResource('institutions', InstitutionController::class);
