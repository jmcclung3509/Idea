<?php

declare(strict_types=1);

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', fn () => view('welcome'));
Route::redirect('/', '/ideas');

Route::get('/ideas', [IdeaController::class, 'index'])->middleware('auth')->name('idea.index');
Route::post('/ideas', [IdeaController::class, 'store'])->middleware('auth')->name('idea.store');
Route::get('/ideas/create', [IdeaController::class, 'create'])->middleware('auth')->name('idea.create');
Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->middleware('auth')->name('idea.show');
Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])->middleware('auth')->name('idea.destroy');

Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');

Route::get('/login', [SessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->middleware('guest');

Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth');
