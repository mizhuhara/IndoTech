<?php

use App\Http\Controllers\AdminCommunityController;
use App\Http\Controllers\AdminCompanyController;
use App\Http\Controllers\AdminInternshipController;
use App\Http\Controllers\AdminJobController;
use App\Http\Controllers\AdminEventController;
use App\Http\Controllers\AdminSchoolController;
use App\Http\Controllers\AdminUnivController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminVerificationController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\KnowledgeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

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

// Admin routes — semua butuh login + role admin
Route::middleware('admin')->group(function () {

// Admin Dashboard
Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');

// Admin School Management
Route::get('/admin/schools', [AdminSchoolController::class, 'index'])->name('admin.schools.index');
Route::get('/admin/schools/create', [AdminSchoolController::class, 'create'])->name('admin.schools.create');
Route::post('/admin/schools', [AdminSchoolController::class, 'store'])->name('admin.schools.store');
Route::get('/admin/schools/{id}', [AdminSchoolController::class, 'show'])->name('admin.schools.show');
Route::get('/admin/schools/{id}/edit', [AdminSchoolController::class, 'edit'])->name('admin.schools.edit');
Route::put('/admin/schools/{id}', [AdminSchoolController::class, 'update'])->name('admin.schools.update');
Route::delete('/admin/schools/{id}', [AdminSchoolController::class, 'destroy'])->name('admin.schools.destroy');

// Admin University Management
Route::get('/admin/univ', [AdminUnivController::class, 'index'])->name('admin.univ.index');
Route::get('/admin/univ/create', [AdminUnivController::class, 'create'])->name('admin.univ.create');
Route::post('/admin/univ', [AdminUnivController::class, 'store'])->name('admin.univ.store');
Route::get('/admin/univ/{id}', [AdminUnivController::class, 'show'])->name('admin.univ.show');
Route::get('/admin/univ/{id}/edit', [AdminUnivController::class, 'edit'])->name('admin.univ.edit');
Route::put('/admin/univ/{id}', [AdminUnivController::class, 'update'])->name('admin.univ.update');
Route::delete('/admin/univ/{id}', [AdminUnivController::class, 'destroy'])->name('admin.univ.destroy');

// Admin Company Management
Route::get('/admin/company', [AdminCompanyController::class, 'index'])->name('admin.company.index');
Route::get('/admin/company/create', [AdminCompanyController::class, 'create'])->name('admin.company.create');
Route::post('/admin/company', [AdminCompanyController::class, 'store'])->name('admin.company.store');
Route::get('/admin/company/{id}', [AdminCompanyController::class, 'show'])->name('admin.company.show');
Route::get('/admin/company/{id}/edit', [AdminCompanyController::class, 'edit'])->name('admin.company.edit');
Route::put('/admin/company/{id}', [AdminCompanyController::class, 'update'])->name('admin.company.update');
Route::delete('/admin/company/{id}', [AdminCompanyController::class, 'destroy'])->name('admin.company.destroy');

// Admin Community Management
Route::get('/admin/community', [AdminCommunityController::class, 'index'])->name('admin.community.index');
Route::get('/admin/community/create', [AdminCommunityController::class, 'create'])->name('admin.community.create');
Route::post('/admin/community', [AdminCommunityController::class, 'store'])->name('admin.community.store');
Route::get('/admin/community/{id}', [AdminCommunityController::class, 'show'])->name('admin.community.show');
Route::get('/admin/community/{id}/edit', [AdminCommunityController::class, 'edit'])->name('admin.community.edit');
Route::put('/admin/community/{id}', [AdminCommunityController::class, 'update'])->name('admin.community.update');
Route::delete('/admin/community/{id}', [AdminCommunityController::class, 'destroy'])->name('admin.community.destroy');

// Admin Jobs Management
Route::get('/admin/jobs', [AdminJobController::class, 'index'])->name('admin.jobs.index');
Route::get('/admin/jobs/create', [AdminJobController::class, 'create'])->name('admin.jobs.create');
Route::post('/admin/jobs', [AdminJobController::class, 'store'])->name('admin.jobs.store');
Route::get('/admin/jobs/{id}', [AdminJobController::class, 'show'])->name('admin.jobs.show');
Route::get('/admin/jobs/{id}/edit', [AdminJobController::class, 'edit'])->name('admin.jobs.edit');
Route::put('/admin/jobs/{id}', [AdminJobController::class, 'update'])->name('admin.jobs.update');
Route::delete('/admin/jobs/{id}', [AdminJobController::class, 'destroy'])->name('admin.jobs.destroy');

// Admin Internships Management
Route::get('/admin/internships', [AdminInternshipController::class, 'index'])->name('admin.internships.index');
Route::get('/admin/internships/create', [AdminInternshipController::class, 'create'])->name('admin.internships.create');
Route::post('/admin/internships', [AdminInternshipController::class, 'store'])->name('admin.internships.store');
Route::get('/admin/internships/{id}', [AdminInternshipController::class, 'show'])->name('admin.internships.show');
Route::get('/admin/internships/{id}/edit', [AdminInternshipController::class, 'edit'])->name('admin.internships.edit');
Route::put('/admin/internships/{id}', [AdminInternshipController::class, 'update'])->name('admin.internships.update');
Route::delete('/admin/internships/{id}', [AdminInternshipController::class, 'destroy'])->name('admin.internships.destroy');

// Admin User & Verification Routes
Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
Route::get('/admin/verification', [AdminVerificationController::class, 'index'])->name('admin.verification.index');
Route::get('/admin/user', function () {
    return redirect()->route('admin.users.index');
});

// Admin Event Verification Routes
Route::get('/admin/events', [AdminEventController::class, 'index'])->name('admin.events.index');
Route::get('/admin/events/{id}', [AdminEventController::class, 'show'])->name('admin.events.show');
Route::post('/admin/events/{id}/approve', [AdminEventController::class, 'approve'])->name('admin.events.approve');
Route::post('/admin/events/{id}/reject', [AdminEventController::class, 'reject'])->name('admin.events.reject');

// Admin Reports
Route::view('/admin/reports', 'admin.reports.index')->name('admin.reports.index');
Route::get('/admin/reports/{id}', function ($id) {
    return view('admin.reports.show', compact('id'));
})->name('admin.reports.show');

// Admin Articles
Route::view('/admin/articles', 'admin.articles.index')->name('admin.articles.index');
Route::view('/admin/articles/create', 'admin.articles.create')->name('admin.articles.create');
Route::get('/admin/articles/{id}/edit', function () {
    return view('admin.articles.create');
})->name('admin.articles.edit');
Route::post('/admin/articles', function () {
    // TODO: handle article store
    return back()->with('success', 'Article berhasil disimpan (stub).');
})->name('admin.articles.store');

}); // end admin group

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
    return redirect()->route('knowledge.show', $id);
});
