<?php

use App\Http\Controllers\Audit\AuditController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Laporan\LaporanController;
use App\Http\Controllers\Master\DomainController;
use App\Http\Controllers\Master\PenggunaController;
use App\Http\Controllers\Master\PertanyaanController;
use App\Http\Controllers\Master\PraktikController;
use App\Http\Controllers\Master\ProsesController;
use App\Http\Controllers\Penilaian\PenilaianController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:5,1');
});

// Sudah login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'password'])->name('profil.password');

    // Khusus admin: data master COBIT
    Route::middleware('role:admin')->prefix('master')->name('master.')->group(function () {
        Route::resource('domain', DomainController::class)->except('show');
        Route::resource('proses', ProsesController::class)->except('show')
            ->parameters(['proses' => 'proses']);
        Route::resource('praktik', PraktikController::class)->except('show')
            ->parameters(['praktik' => 'praktik']);
        Route::resource('pertanyaan', PertanyaanController::class)->except('show')
            ->parameters(['pertanyaan' => 'pertanyaan']);
        Route::resource('pengguna', PenggunaController::class)->except('show')
            ->parameters(['pengguna' => 'pengguna']);
    });

    // Khusus admin: proyek audit
    Route::middleware('role:admin')->group(function () {
        Route::resource('audit', AuditController::class);
    });

    // Laporan hasil audit (admin & asesor pemilik proyek)
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/{audit}', [LaporanController::class, 'show'])->name('show');
        Route::get('/{audit}/cetak', [LaporanController::class, 'cetak'])->name('cetak');
    });

    // Khusus asesor: penilaian
    Route::middleware('role:asesor')->prefix('penilaian')->name('penilaian.')->group(function () {
        Route::get('/', [PenilaianController::class, 'index'])->name('index');
        Route::get('/{audit}', [PenilaianController::class, 'show'])->name('show');
        Route::get('/{audit}/{proses}', [PenilaianController::class, 'workspace'])->name('workspace');
        Route::post('/{audit}/{proses}', [PenilaianController::class, 'simpan'])->name('simpan');
        Route::post('/{audit}/{proses}/reset', [PenilaianController::class, 'reset'])->name('reset');
    });
});
