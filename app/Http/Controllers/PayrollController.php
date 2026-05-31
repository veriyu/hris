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

    public function downloadAll(\App\Models\PayrollPeriod $payrollPeriod, PayrollAction $action)
    {
        $payrolls = \App\Models\Payroll::where('payroll_period_id', $payrollPeriod->id)->get();
        
        if ($payrolls->isEmpty()) {
            return redirect()->back()->with('error', 'No payrolls found for this period.');
        }

        $zip = new \ZipArchive();
        $zipFileName = 'Payslips_' . str_replace(' ', '_', $payrollPeriod->name) . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            foreach ($payrolls as $payroll) {
                // Generate PDF content (not stream)
                $payroll->load(['employee.company', 'employee.position', 'payrollPeriod', 'items']);
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.payslip', [
                    'payroll' => $payroll,
                    'employee' => $payroll->employee,
                    'company' => $payroll->employee->company,
                    'period' => $payroll->payrollPeriod,
                    'items' => $payroll->items,
                ]);
                
                $pdfContent = $pdf->output();
                $employeeName = str_replace(' ', '_', $payroll->employee->first_name . '_' . $payroll->employee->last_name);
                $fileName = 'Payslip_' . $employeeName . '.pdf';
                
                $zip->addFromString($fileName, $pdfContent);
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function downloadFinance(\App\Models\PayrollPeriod $payrollPeriod)
    {
        $payrolls = $payrollPeriod->payrolls()
            ->with(['employee.bank', 'items'])
            ->get();
        
        $totalBasicSalary = 0;
        $totalAllowance = 0;
        $totalDeduction = 0;
        $totalNetSalary = 0;

        foreach ($payrolls as $payroll) {
            $totalBasicSalary += $payroll->basic_salary;
            $totalAllowance += $payroll->total_allowance;
            $totalDeduction += $payroll->total_deduction;
            $totalNetSalary += $payroll->net_salary;
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.payroll_finance', [
            'period' => $payrollPeriod,
            'payrolls' => $payrolls,
            'totalBasicSalary' => $totalBasicSalary,
            'totalAllowance' => $totalAllowance,
            'totalDeduction' => $totalDeduction,
            'totalNetSalary' => $totalNetSalary,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('Payroll_Finance_Report_' . $payrollPeriod->name . '.pdf');
    }
}
