<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekapitulasi Pembayaran Gaji - {{ $period->name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 40px; }
        .title { font-size: 20px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .subtitle { font-size: 14px; color: #666; }
        table { width: 80%; margin: 0 auto; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 12px; }
        th { background-color: #f4f4f4; text-align: left; width: 60%; }
        .amount { text-align: right; font-weight: bold; }
        .grand-total { background-color: #e2e8f0; font-size: 16px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">RINGKASAN REKAPITULASI GAJI</div>
        <div class="subtitle">Periode: {{ $period->name }}</div>
    </div>

    <table>
        <tbody>
            <tr>
                <th>Total Gaji sebelum potongan</th>
                <td class="amount">Rp {{ number_format($totalGrossSalary, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total potongan BPJS</th>
                <td class="amount" style="color: #d32f2f;">Rp {{ number_format($totalBPJS, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total potongan lainnya</th>
                <td class="amount" style="color: #d32f2f;">Rp {{ number_format($totalOtherDeductions, 0, ',', '.') }}</td>
            </tr>
            <tr class="grand-total">
                <th>Total gaji realisasi cair</th>
                <td class="amount" style="color: #1976d2;">Rp {{ number_format($totalNetSalary, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 60px; width: 80%; margin-left: auto; margin-right: auto;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="text-align: center; width: 50%; border: none;">
                    Dibuat Oleh,
                    <br><br><br><br><br>
                    ( ____________________ )<br>
                    <strong>HR Manager</strong>
                </td>
                <td style="text-align: center; width: 50%; border: none;">
                    Disetujui Oleh,
                    <br><br><br><br><br>
                    ( ____________________ )<br>
                    <strong>Finance Manager</strong>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
