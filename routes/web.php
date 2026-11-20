<?php

use App\Http\Controllers\FilmController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/films');

// Мгновенная проверка дубликатов (AJAX) при вводе в форме создания/редактирования
Route::get('films/check-duplicate', [FilmController::class, 'checkDuplicate'])
    ->name('films.check-duplicate');

Route::resource('films', FilmController::class);
