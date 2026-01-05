<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\TemplateController as AdminTemplateController;
use App\Http\Controllers\Admin\ArchiveController as AdminArchiveController;
use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use App\Http\Controllers\Anggota\DashboardController as AnggotaDashboardController;
use App\Http\Controllers\Anggota\TemplateController as AnggotaTemplateController;
use App\Http\Controllers\Anggota\SuratController as AnggotaSuratController;
use App\Http\Controllers\Anggota\ArchiveController as AnggotaArchiveController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User management
    Route::resource('users', AdminUserController::class);
    Route::post('users/{id}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    
    // Template management
    Route::resource('templates', AdminTemplateController::class);
    
    // Archive management
    Route::get('/archive', [AdminArchiveController::class, 'index'])->name('archive.index');
    Route::get('/archive/{id}/download/{type?}', [AdminArchiveController::class, 'download'])->name('archive.download');
    
    // Activity logs
    Route::get('/activity-logs', [AdminActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/{id}', [AdminActivityLogController::class, 'show'])->name('activity-logs.show');
    Route::delete('/activity-logs/reset', [AdminActivityLogController::class, 'reset'])->name('activity-logs.reset');
});

// Anggota routes
Route::middleware(['auth', 'anggota'])->prefix('anggota')->name('anggota.')->group(function () {
    Route::get('/dashboard', [AnggotaDashboardController::class, 'index'])->name('dashboard');
    
    // Templates
    Route::get('/templates', [AnggotaTemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/{id}', [AnggotaTemplateController::class, 'show'])->name('templates.show');
    
    // Surat management
    Route::get('/surat/create', [AnggotaSuratController::class, 'create'])->name('surat.create');
    Route::post('/surat', [AnggotaSuratController::class, 'store'])->name('surat.store');
    Route::get('/surat/{id}', [AnggotaSuratController::class, 'show'])->name('surat.show');
    Route::get('/surat/{id}/download/{type?}', [AnggotaSuratController::class, 'download'])->name('surat.download');
    
    // Personal archive
    Route::get('/archive', [AnggotaArchiveController::class, 'index'])->name('archive.index');
});
