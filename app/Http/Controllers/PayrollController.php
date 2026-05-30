<?php

namespace App\Http\Controllers;

use App\Actions\PayrollAction;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function download(Payroll $payroll, PayrollAction $action)
    {
        // Add authorization check later if needed
        return $action->generatePayslip($payroll);
    }
}
