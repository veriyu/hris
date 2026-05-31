<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Form Filter Periode (Clean & Minimalist) -->
        <div class="p-6 bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm no-print">
            <form wire:submit.prevent="tampilkan" class="flex flex-col sm:flex-row gap-4 items-end">
                <div class="flex-1 w-full max-w-md">
                    {{ $this->form }}
                </div>
                
                <div class="flex gap-2 w-full sm:w-auto">
                    <x-filament::button type="submit" class="flex-1 sm:flex-none">
                        Tampilkan Laporan
                    </x-filament::button>

                    @if($isSubmitted && $payroll_period_id && $payrolls->isNotEmpty())
                    <x-filament::button 
                        tag="a" 
                        href="{{ route('payroll-period.download-finance', $payroll_period_id) }}" 
                        target="_blank" 
                        color="success" 
                        icon="heroicon-o-arrow-down-tray"
                        class="flex-1 sm:flex-none">
                        Stream PDF
                    </x-filament::button>
                    @endif
                </div>
            </form>
        </div>

        @if($isSubmitted)
            @if($payrolls->isNotEmpty())
                <!-- Tampilan Laporan Standar Klasik (Format Buku Kas / Laporan Akuntansi) -->
                <div class="p-8 bg-white dark:bg-gray-900 rounded-xl border border-gray-300 dark:border-gray-700 shadow-sm space-y-6">
                    
                    <!-- Kop Laporan Klasik -->
                    <div class="pb-4 border-b-2 border-gray-800 dark:border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h2 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white uppercase font-serif">HRMS</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-sans tracking-wide">Sistem Penggajian & HRMS Terintegrasi</p>
                        </div>
                        <div class="md:text-right">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white uppercase font-serif tracking-tight">REKAPITULASI PEMBAYARAN GAJI KARYAWAN</h3>
                            <p class="text-xs text-gray-600 dark:text-gray-400 font-sans">
                                Periode: <span class="font-bold text-gray-800 dark:text-gray-200">{{ $payrolls->first()->payrollPeriod->name }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Tabel Standar Laporan Klasik (Grid Tebal, Styling Akuntansi) -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left border-collapse border border-gray-400 dark:border-gray-600 font-sans">
                            <thead>
                                <tr class="bg-slate-800 text-white dark:bg-slate-700">
                                    <th class="border border-gray-400 dark:border-gray-600 px-4 py-3 text-center font-bold tracking-wide uppercase text-xs w-12">No</th>
                                    <th class="border border-gray-400 dark:border-gray-600 px-4 py-3 font-bold tracking-wide uppercase text-xs">Nama Karyawan</th>
                                    <th class="border border-gray-400 dark:border-gray-600 px-4 py-3 text-center font-bold tracking-wide uppercase text-xs w-28">Bank</th>
                                    <th class="border border-gray-400 dark:border-gray-600 px-4 py-3 text-center font-bold tracking-wide uppercase text-xs">Nomor Rekening</th>
                                    <th class="border border-gray-400 dark:border-gray-600 px-4 py-3 font-bold tracking-wide uppercase text-xs">Nama Pemilik Rekening</th>
                                    <th class="border border-gray-400 dark:border-gray-600 px-4 py-3 text-right font-bold tracking-wide uppercase text-xs w-44">Gaji Bersih</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-400 dark:divide-gray-600">
                                @php
                                    $totalNet = $payrolls->sum('net_salary');
                                @endphp
                                
                                @foreach($payrolls as $index => $payroll)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition duration-150">
                                    <td class="border border-gray-400 dark:border-gray-600 px-4 py-2.5 text-center text-gray-700 dark:text-gray-300 font-mono">{{ $index + 1 }}</td>
                                    <td class="border border-gray-400 dark:border-gray-600 px-4 py-2.5 font-bold text-gray-950 dark:text-white">
                                        {{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}
                                    </td>
                                    <td class="border border-gray-400 dark:border-gray-600 px-4 py-2.5 text-center font-bold text-gray-900 dark:text-gray-200">
                                        {{ $payroll->employee->bank->name ?? '-' }}
                                    </td>
                                    <td class="border border-gray-400 dark:border-gray-600 px-4 py-2.5 text-center font-mono font-bold text-gray-950 dark:text-white tracking-wider">
                                        {{ $payroll->employee->bank_account_number ?? '-' }}
                                    </td>
                                    <td class="border border-gray-400 dark:border-gray-600 px-4 py-2.5 text-gray-900 dark:text-gray-100 font-medium">
                                        {{ $payroll->employee->bank_account_name ?? '-' }}
                                    </td>
                                    <td class="border border-gray-400 dark:border-gray-600 px-4 py-2.5 text-right font-bold text-slate-900 dark:text-white font-mono text-base">
                                        Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach

                                <!-- Baris Total Kas / Akuntansi Klasik (Double Line Bottom Border) -->
                                <tr class="bg-slate-100 dark:bg-slate-800 font-bold border-t-2 border-b-4 border-double border-gray-800 dark:border-gray-200">
                                    <td colspan="5" class="border border-gray-400 dark:border-gray-600 px-4 py-3 text-right text-gray-950 dark:text-white uppercase tracking-wider font-serif">Total Keseluruhan :</td>
                                    <td class="border border-gray-400 dark:border-gray-600 px-4 py-3 text-right text-slate-900 dark:text-white font-mono text-base">
                                        Rp {{ number_format($totalNet, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="p-8 text-center bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
                    <div class="mx-auto w-12 h-12 text-gray-400 dark:text-gray-600 mb-3">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">Tidak Ada Data</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Tidak ditemukan data payroll untuk periode penggajian yang Anda pilih.</p>
                </div>
            @endif
        @endif
    </div>
</x-filament-panels::page>
