<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CorrectResultController;

Route::resource('correct-results', CorrectResultController::class);
Route::get('/', CorrectResultController::class.'@index');
