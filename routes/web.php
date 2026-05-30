<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayrollController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/payroll/{payroll}/download', [PayrollController::class, 'download'])
    ->name('payroll.download')
    ->middleware('auth');

Route::get('/payroll-period/{payrollPeriod}/download-all', [PayrollController::class, 'downloadAll'])
    ->name('payroll-period.download-all')
    ->middleware('auth');
