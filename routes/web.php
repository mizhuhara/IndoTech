<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CareerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/career', [CareerController::class, 'index'])->name('career.index');
