<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
    </form>

    @if($this->payroll_period_id)
        @livewire(\App\Filament\Widgets\PayrollSummaryStats::class, ['payroll_period_id' => $this->payroll_period_id])
        
        <div class="mt-6">
            {{ $this->table }}
        </div>
    @else
        <x-filament::card class="text-center py-12">
            <x-heroicon-o-document-magnifying-glass class="w-12 h-12 mx-auto text-gray-400 mb-4" />
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pilih Periode Payroll</h3>
            <p class="text-gray-500 dark:text-gray-400">Silakan pilih periode payroll di atas untuk melihat laporan dan rincian per divisi.</p>
        </x-filament::card>
    @endif
</x-filament-panels::page>
