<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekapitulasi Pembayaran Gaji - {{ $period->name }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 30px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #1a56db;
            padding-bottom: 10px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        .header-table td {
            border: none;
            padding: 0;
        }
        .company-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
        }
        .report-title {
            font-size: 14px;
            font-weight: bold;
            color: #111827;
            text-align: right;
        }
        .subtitle {
            font-size: 10px;
            color: #4b5563;
        }
        .subtitle-right {
            font-size: 10px;
            color: #4b5563;
            text-align: right;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .content-table th {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            border: 1px solid #1e3a8a;
            padding: 8px 6px;
            text-align: center;
        }
        .content-table td {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
            vertical-align: middle;
        }
        .content-table tr:nth-child(even) td {
            background-color: #f9fafb;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }
        .font-semibold {
            font-weight: 600;
        }
        .grand-total td {
            background-color: #f3f4f6 !important;
            font-weight: bold;
            border-top: 2px solid #1e3a8a;
            border-bottom: 2px solid #1e3a8a;
            padding: 8px 10px;
        }
        .signatures {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
            border: none;
            page-break-inside: avoid;
        }
        .signatures td {
            border: none;
            width: 33%;
            text-align: center;
            padding: 10px;
            vertical-align: top;
        }
        .signature-title {
            margin-bottom: 55px;
            font-size: 10px;
            color: #374151;
        }
        .signature-line {
            width: 160px;
            border-bottom: 1px solid #4b5563;
            margin: 0 auto 4px auto;
        }
        .signature-name {
            font-weight: bold;
            font-size: 10px;
            color: #111827;
        }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    <div class="company-title">HRMS</div>
                    <div class="subtitle">Sistem Penggajian & HRMS Terintegrasi</div>
                </td>
                <td>
                    <div class="report-title">REKAPITULASI PEMBAYARAN GAJI KARYAWAN</div>
                    <div class="subtitle-right">Periode: <strong>{{ $period->name }}</strong> ({{ $period->start_date->format('d/m/Y') }} - {{ $period->end_date->format('d/m/Y') }})</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="content-table">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="28%">Nama Karyawan</th>
                <th width="15%">Bank Tujuan</th>
                <th width="18%">Nomor Rekening</th>
                <th width="20%">Nama Pemilik Rekening</th>
                <th width="15%">Gaji Bersih</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payrolls as $index => $payroll)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="font-semibold text-left">{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</td>
                <td class="text-center">{{ $payroll->employee->bank->name ?? '-' }}</td>
                <td class="text-center font-semibold">{{ $payroll->employee->bank_account_number ?? '-' }}</td>
                <td class="text-left">{{ $payroll->employee->bank_account_name ?? '-' }}</td>
                <td class="text-right font-semibold" style="color: #1e3a8a;">Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px; color: #6b7280;">
                    Tidak ada data payroll untuk periode ini.
                </td>
            </tr>
            @endforelse
            
            @if($payrolls->isNotEmpty())
            <tr class="grand-total">
                <td colspan="5" class="text-right">TOTAL KESELURUHAN :</td>
                <td class="text-right" style="color: #1e3a8a;">Rp {{ number_format($totalNetSalary, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <table class="signatures">
        <tr>
            <td>
                <div class="signature-title">Dibuat Oleh,</div>
                <div class="signature-line"></div>
                <div class="signature-name">HR Staff / Officer</div>
            </td>
            <td>
                <div class="signature-title">Diverifikasi Oleh,</div>
                <div class="signature-line"></div>
                <div class="signature-name">HR Manager</div>
            </td>
            <td>
                <div class="signature-title">Disetujui & Dibayarkan Oleh,</div>
                <div class="signature-line"></div>
                <div class="signature-name">Finance Manager / Bendahara</div>
            </td>
        </tr>
    </table>
</body>
</html>
