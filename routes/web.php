<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndustryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/industry', [IndustryController::class, 'index'])->name('industry');

