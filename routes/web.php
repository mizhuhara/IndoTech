<?php

use App\Http\Controllers\CampusController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\KnowledgeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/education', [EducationController::class, 'index'])->name('education.index');
Route::get('/education/{id}', [EducationController::class, 'show'])->name('education.show');

Route::get('/campus', [CampusController::class, 'index'])->name('campus.index');
Route::get('/campus/{id}', [CampusController::class, 'show'])->name('campus.show');

Route::get('/industry', [IndustryController::class, 'index'])->name('industry');

Route::get('/career', [CareerController::class, 'index'])->name('career.index');
Route::get('/career/{id}/apply', [CareerController::class, 'apply'])->name('career.apply');
Route::post('/career/{id}/apply', [CareerController::class, 'storeApplication'])->name('career.apply.store');

Route::get('/events', [EventController::class, 'index'])->name('event.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('event.show');
Route::get('/event', function () {
    return redirect()->route('event.index');
});
Route::get('/event/{id}', function ($id) {
    return redirect()->route('event.show', $id);
});

// Admin Dashboard
Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');

// Admin Reports
Route::view('/admin/reports', 'admin.reports.index')->name('admin.reports.index');
Route::get('/admin/reports/{id}', function ($id) {
    return view('admin.reports.show', compact('id'));
})->name('admin.reports.show');

// Auth Routes
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', function () {
    // TODO: handle login — stub, belum ada auth logic
    return back()->withErrors(['email' => 'Login belum tersedia.']);
})->name('login.submit');

Route::view('/register', 'auth.register')->name('register');
Route::post('/register', function () {
    // TODO: handle register — stub, belum ada auth logic
    return back()->withErrors(['email' => 'Register belum tersedia.']);
})->name('register.submit');

// Knowledge Hub Routes
Route::get('/knowledge-hub', [KnowledgeController::class, 'index'])->name('knowledge.index');
Route::get('/knowledge-hub/ai', [KnowledgeController::class, 'ai'])->name('knowledge.ai');
Route::get('/knowledge-hub/ai/{id}', [KnowledgeController::class, 'aiDetail'])->name('knowledge.ai.detail');
Route::get('/knowledge-hub/article/{id}', [KnowledgeController::class, 'show'])->name('knowledge.show');

// Support /knowladge legacy/typo URL as alias
Route::get('/knowladge', function () {
    return redirect()->route('knowledge.index');
});
Route::get('/knowladge/ai', function () {
    return redirect()->route('knowledge.ai');
});
Route::get('/knowladge/ai/{id}', function ($id) {
    return redirect()->route('knowledge.ai.detail', $id);
});
Route::get('/knowladge/article/{id}', function ($id) {
    return redirect()->route('knowledge.ai.detail', $id);
});
