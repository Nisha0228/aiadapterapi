<?php

use Illuminate\Support\Facades\Route;
use Nisha0228\Aiadapter\Controllers\AiadapterController;

Route::get('adapter/categorize/{quiz}', [AiadapterController::class, 'categorize']);
Route::get('adapter/questions/{count}/{difficulty}', [AiadapterController::class, 'questions']);
Route::get('adapter/questions/{theme}/{count}/{difficulty}', [AiadapterController::class, 'theme']);
