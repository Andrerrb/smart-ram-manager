<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemoryController;

Route::get('/', [MemoryController::class, 'home'])->name('home');

Route::get('/metodos-basicos', [MemoryController::class, 'basicMethods'])
    ->name('basic.methods');

Route::get('/algoritmos-geneticos', [MemoryController::class, 'geneticAlgorithms'])
    ->name('genetic.algorithms');

Route::get('/sobre', [MemoryController::class, 'about'])
    ->name('about');

Route::post('/gerar-problema', [MemoryController::class, 'generateProblem'])
    ->name('problem.generate');

Route::post('/solucao-inicial', [MemoryController::class, 'initialSolution'])
    ->name('solution.initial');

Route::post('/executar-metodo', [MemoryController::class, 'executeMethod'])
    ->name('method.execute');