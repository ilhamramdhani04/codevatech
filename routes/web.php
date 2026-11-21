<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\GejalaController;
use App\Http\Controllers\Admin\KerusakanController;
use App\Http\Controllers\Admin\PenyebabController;
use App\Http\Controllers\Admin\SolusiController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\Admin\DiagnosisHistoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\LaptopModelController;
use App\Http\Controllers\Admin\AnalyticsController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('diagnosis')->name('diagnosis.')->group(function () {
    Route::get('/', [DiagnosisController::class, 'index'])->name('index');
    Route::post('/', [DiagnosisController::class, 'process'])
         ->middleware('throttle:diagnosis')
         ->name('process');
    Route::get('/hasil', [DiagnosisController::class, 'result'])->name('result');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Shared login entry point — always at /admin/login)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])
         ->middleware('throttle:login')
         ->name('login.post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Shared Panel Routes (used by both Admin & Teknisi portals)
|--------------------------------------------------------------------------
*/

$panelRoutes = function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Read-only viewing of Knowledge Base & Katalog
    Route::get('/kategoris', [KategoriController::class, 'index'])->name('kategoris.index');
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/laptop-models', [LaptopModelController::class, 'index'])->name('laptop-models.index');
    Route::get('/gejalas', [GejalaController::class, 'index'])->name('gejalas.index');
    Route::get('/kerusakans', [KerusakanController::class, 'index'])->name('kerusakans.index');
    Route::get('/kerusakans/{kerusakan}', [KerusakanController::class, 'show'])->name('kerusakans.show');
    Route::get('/rules', [RuleController::class, 'index'])->name('rules.index');
    Route::get('/rules/{rule}', [RuleController::class, 'show'])->name('rules.show');

    // Riwayat Diagnosis
    Route::get('/riwayat', [DiagnosisHistoryController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/export', [DiagnosisHistoryController::class, 'export'])->name('riwayat.export');
    Route::get('/riwayat/{riwayat}', [DiagnosisHistoryController::class, 'show'])->name('riwayat.show');
    Route::get('/riwayat/{riwayat}/print', [DiagnosisHistoryController::class, 'print'])->name('riwayat.print');
    Route::get('/riwayat/{riwayat}/pdf', [DiagnosisHistoryController::class, 'downloadPdf'])->name('riwayat.pdf');
};

/*
|--------------------------------------------------------------------------
| Admin Portal — /admin/* (Role: admin only)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['admin', 'role:admin'])->group(function () use ($panelRoutes) {
    /*
    |--------------------------------------------------------------------------
    | Admin-Only Routes — Mutations & User Management
    | HARUS didaftarkan SEBELUM $panelRoutes() agar route static seperti
    | /kerusakans/create tidak tertangkap oleh wildcard /{kerusakan}
    |--------------------------------------------------------------------------
    */

    // User Management
    Route::resource('users', UserController::class)->except(['show']);

    // Analisis & Insight Kerusakan (Admin Only)
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/data', [AnalyticsController::class, 'data'])->name('analytics.data');

    // Kategori Mutations
    Route::get('/kategoris/create', [KategoriController::class, 'create'])->name('kategoris.create');
    Route::post('/kategoris', [KategoriController::class, 'store'])->name('kategoris.store');
    Route::get('/kategoris/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategoris.edit');
    Route::put('/kategoris/{kategori}', [KategoriController::class, 'update'])->name('kategoris.update');
    Route::delete('/kategoris/{kategori}', [KategoriController::class, 'destroy'])->name('kategoris.destroy');

    // Brand Mutations
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

    // Laptop Model Mutations
    Route::get('/laptop-models/create', [LaptopModelController::class, 'create'])->name('laptop-models.create');
    Route::post('/laptop-models', [LaptopModelController::class, 'store'])->name('laptop-models.store');
    Route::get('/laptop-models/{laptop_model}/edit', [LaptopModelController::class, 'edit'])->name('laptop-models.edit');
    Route::put('/laptop-models/{laptop_model}', [LaptopModelController::class, 'update'])->name('laptop-models.update');
    Route::delete('/laptop-models/{laptop_model}', [LaptopModelController::class, 'destroy'])->name('laptop-models.destroy');

    // Gejala Mutations
    Route::get('/gejalas/create', [GejalaController::class, 'create'])->name('gejalas.create');
    Route::post('/gejalas', [GejalaController::class, 'store'])->name('gejalas.store');
    Route::get('/gejalas/{gejala}/edit', [GejalaController::class, 'edit'])->name('gejalas.edit');
    Route::put('/gejalas/{gejala}', [GejalaController::class, 'update'])->name('gejalas.update');
    Route::patch('/gejalas/{gejala}/toggle-frequent', [GejalaController::class, 'toggleFrequent'])->name('gejalas.toggle-frequent');
    Route::patch('/gejalas/{gejala}/group', [GejalaController::class, 'updateGroup'])->name('gejalas.update-group');
    Route::delete('/gejalas/{gejala}', [GejalaController::class, 'destroy'])->name('gejalas.destroy');

    // Kerusakan Mutations
    Route::get('/kerusakans/create', [KerusakanController::class, 'create'])->name('kerusakans.create');
    Route::post('/kerusakans', [KerusakanController::class, 'store'])->name('kerusakans.store');
    Route::get('/kerusakans/{kerusakan}/edit', [KerusakanController::class, 'edit'])->name('kerusakans.edit');
    Route::put('/kerusakans/{kerusakan}', [KerusakanController::class, 'update'])->name('kerusakans.update');
    Route::delete('/kerusakans/{kerusakan}', [KerusakanController::class, 'destroy'])->name('kerusakans.destroy');

    // Nested Penyebab Mutations
    Route::get('/kerusakans/{kerusakan}/penyebabs/create', [PenyebabController::class, 'create'])->name('kerusakans.penyebabs.create');
    Route::post('/kerusakans/{kerusakan}/penyebabs', [PenyebabController::class, 'store'])->name('penyebabs.store');
    Route::get('/kerusakans/{kerusakan}/penyebabs/{penyebab}/edit', [PenyebabController::class, 'edit'])->name('penyebabs.edit');
    Route::put('/kerusakans/{kerusakan}/penyebabs/{penyebab}', [PenyebabController::class, 'update'])->name('penyebabs.update');
    Route::delete('/kerusakans/{kerusakan}/penyebabs/{penyebab}', [PenyebabController::class, 'destroy'])->name('penyebabs.destroy');

    // Nested Solusi Mutations
    Route::get('/kerusakans/{kerusakan}/solusis/create', [SolusiController::class, 'create'])->name('kerusakans.solusis.create');
    Route::post('/kerusakans/{kerusakan}/solusis', [SolusiController::class, 'store'])->name('solusis.store');
    Route::get('/kerusakans/{kerusakan}/solusis/{solusi}/edit', [SolusiController::class, 'edit'])->name('solusis.edit');
    Route::put('/kerusakans/{kerusakan}/solusis/{solusi}', [SolusiController::class, 'update'])->name('solusis.update');
    Route::delete('/kerusakans/{kerusakan}/solusis/{solusi}', [SolusiController::class, 'destroy'])->name('solusis.destroy');

    // Rule Mutations
    Route::get('/rules/create', [RuleController::class, 'create'])->name('rules.create');
    Route::post('/rules', [RuleController::class, 'store'])->name('rules.store');
    Route::get('/rules/{rule}/edit', [RuleController::class, 'edit'])->name('rules.edit');
    Route::put('/rules/{rule}', [RuleController::class, 'update'])->name('rules.update');
    Route::delete('/rules/{rule}', [RuleController::class, 'destroy'])->name('rules.destroy');

    // Shared read-only panel routes (index, show, riwayat) — didaftarkan TERAKHIR
    // agar wildcard {kerusakan}/{gejala}/{rule} tidak menangkap "create" atau "edit"
    $panelRoutes();
});

/*
|--------------------------------------------------------------------------
| Teknisi Portal — /teknisi/* (Role: teknisi only)
|--------------------------------------------------------------------------
*/

Route::prefix('teknisi')->name('teknisi.')->middleware(['admin', 'role:teknisi'])->group(function () use ($panelRoutes) {
    $panelRoutes();
});
