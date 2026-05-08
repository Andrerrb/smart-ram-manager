<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemoryController;

Route::get('/', [MemoryController::class, 'index']);

Route::post('/calculate', [MemoryController::class, 'calculate'])
    ->name('memory.calculate');