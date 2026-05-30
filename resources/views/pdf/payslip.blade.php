<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slip Gaji - {{ $employee->first_name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .company-name { font-size: 18px; font-weight: bold; text-transform: uppercase; }
        .title { font-size: 16px; margin-top: 10px; font-weight: bold; text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .info-table td { padding: 4px; }
        .details-table th, .details-table td { border: 1px solid #ddd; padding: 6px; }
        .details-table th { background-color: #f4f4f4; text-align: center; }
        .amount { text-align: right; }
        .section-title { font-weight: bold; background-color: #fafafa; }
        .total-row { font-weight: bold; font-size: 13px; background-color: #f4f4f4; }
        .terbilang { font-style: italic; background-color: #f9f9f9; padding: 8px; border: 1px dashed #ccc; margin-bottom: 20px;}
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $company->name ?? 'NAMA PERUSAHAAN' }}</div>
        <div>Slip Gaji Periode: {{ $period->name }}</div>
        <div class="title">SLIP GAJI KARYAWAN</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Nama Lengkap</strong></td>
            <td width="35%">: {{ $employee->first_name }} {{ $employee->last_name }}</td>
            <td width="15%"><strong>No. Pegawai</strong></td>
            <td width="35%">: {{ $employee->employee_number }}</td>
        </tr>
        <tr>
            <td><strong>Jabatan</strong></td>
            <td>: {{ $employee->position->name ?? '-' }}</td>
            <td><strong>Departemen</strong></td>
            <td>: {{ $employee->position->department->name ?? '-' }}</td>
        </tr>
    </table>

    <table class="details-table">
        <thead>
            <tr>
                <th width="70%">Keterangan</th>
                <th width="30%" class="amount">Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr class="section-title">
                <td colspan="2">Penerimaan (Penambah)</td>
            </tr>
            <tr>
                <td>Gaji Pokok</td>
                <td class="amount">{{ number_format($payroll->basic_salary, 0, ',', '.') }}</td>
            </tr>
            @foreach($items->where('type', 'Earning') as $earning)
            <tr>
                <td>Tunjangan: {{ $earning->name }}</td>
                <td class="amount">{{ number_format($earning->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            
            <tr class="section-title">
                <td colspan="2">Potongan (Pengurang)</td>
            </tr>
            @forelse($items->where('type', 'Deduction') as $deduction)
            <tr>
                <td>Potongan: {{ $deduction->name }}</td>
                <td class="amount">({{ number_format($deduction->amount, 0, ',', '.') }})</td>
            </tr>
            @empty
            <tr>
                <td>Tidak ada potongan</td>
                <td class="amount">-</td>
            </tr>
            @endforelse

            <tr class="total-row">
                <td>Take Home Pay (Gaji Bersih)</td>
                <td class="amount">{{ number_format($payroll->net_salary, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="terbilang">
        <strong>Terbilang:</strong> {{ $payroll->terbilang }}
    </div>

    <div style="margin-top: 40px;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="text-align: center; width: 50%; border: none;">
                    Dibuat Oleh,
                    <br><br><br><br><br>
                    ( ____________________ )<br>
                    <strong>HR / Finance</strong>
                </td>
                <td style="text-align: center; width: 50%; border: none;">
                    Diterima Oleh,
                    <br><br><br><br><br>
                    ( <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong> )<br>
                    Karyawan
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
