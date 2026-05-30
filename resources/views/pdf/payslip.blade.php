<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip - {{ $employee->first_name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .company-name { font-size: 18px; font-weight: bold; }
        .title { font-size: 16px; margin-top: 10px; font-weight: bold; text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 4px; }
        .details-table th, .details-table td { border: 1px solid #ddd; padding: 8px; }
        .details-table th { background-color: #f4f4f4; text-align: left; }
        .amount { text-align: right; }
        .total-row { font-weight: bold; background-color: #f4f4f4; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $company->name ?? 'Company Name' }}</div>
        <div>Payslip for Period: {{ $period->name }}</div>
        <div class="title">PAYSLIP</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Employee Name</strong></td>
            <td width="35%">: {{ $employee->first_name }} {{ $employee->last_name }}</td>
            <td width="15%"><strong>Employee No</strong></td>
            <td width="35%">: {{ $employee->employee_number }}</td>
        </tr>
        <tr>
            <td><strong>Position</strong></td>
            <td>: {{ $employee->position->name ?? '-' }}</td>
            <td><strong>Department</strong></td>
            <td>: {{ $employee->position->department->name ?? '-' }}</td>
        </tr>
    </table>

    <table class="details-table">
        <thead>
            <tr>
                <th>Description</th>
                <th class="amount">Amount (IDR)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Basic Salary</td>
                <td class="amount">{{ number_format($payroll->basic_salary, 2) }}</td>
            </tr>
            @foreach($items->where('type', 'Earning') as $earning)
            <tr>
                <td>+ {{ $earning->name }}</td>
                <td class="amount">{{ number_format($earning->amount, 2) }}</td>
            </tr>
            @endforeach
            @foreach($items->where('type', 'Deduction') as $deduction)
            <tr>
                <td>- {{ $deduction->name }}</td>
                <td class="amount">({{ number_format($deduction->amount, 2) }})</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td>Net Salary</td>
                <td class="amount">{{ number_format($payroll->net_salary, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 50px;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="text-align: center; width: 50%;">
                    Prepared By,
                    <br><br><br><br>
                    (____________________)
                </td>
                <td style="text-align: center; width: 50%;">
                    Received By,
                    <br><br><br><br>
                    ({{ $employee->first_name }} {{ $employee->last_name }})
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
