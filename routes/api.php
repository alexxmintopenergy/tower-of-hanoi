<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::get('/state', [GameController::class, 'getState']);
Route::post('/move/{from}/{to}', [GameController::class, 'move']);
Route::post('/reset', [GameController::class, 'reset']);
