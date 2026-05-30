<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayrollController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/payroll/{payroll}/download', [PayrollController::class, 'download'])
    ->name('payroll.download')
    ->middleware('auth');
