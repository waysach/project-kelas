<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');


// =========================
// LAPORAN
// =========================

Route::get('/reports', [ReportController::class, 'index'])
    ->name('reports.index');

Route::get('/reports/pdf', [ReportController::class, 'pdf'])
    ->name('reports.pdf');


// =========================
// TRANSAKSI
// =========================

Route::get('/transactions', [TransactionController::class, 'index'])
    ->name('transactions.index');

Route::get('/transactions/create', [TransactionController::class, 'create'])
    ->name('transactions.create');

Route::post('/transactions', [TransactionController::class, 'store'])
    ->name('transactions.store');

Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])
    ->name('transactions.edit');

Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])
    ->name('transactions.update');

Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])
    ->name('transactions.destroy');
    
Route::resource('students', StudentController::class);