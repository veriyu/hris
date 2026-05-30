<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold">Today's Attendance</h2>
                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::today()->format('l, d F Y') }}</p>
            </div>
            
            <div class="flex space-x-3">
                @if(!$todayAttendance)
                    <x-filament::button wire:click="checkIn" color="primary" icon="heroicon-o-arrow-right-end-on-rectangle">
                        Check In
                    </x-filament::button>
                @elseif($todayAttendance && !$todayAttendance->check_out)
                    <div class="text-right mr-4">
                        <p class="text-sm text-gray-500">Checked in at</p>
                        <p class="font-semibold text-green-600">{{ $todayAttendance->check_in->format('H:i') }}</p>
                    </div>
                    <x-filament::button wire:click="checkOut" color="danger" icon="heroicon-o-arrow-left-start-on-rectangle">
                        Check Out
                    </x-filament::button>
                @else
                    <div class="flex space-x-6">
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Checked in</p>
                            <p class="font-semibold text-green-600">{{ $todayAttendance->check_in->format('H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Checked out</p>
                            <p class="font-semibold text-red-600">{{ $todayAttendance->check_out->format('H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="font-semibold text-primary-600">{{ $todayAttendance->status->getLabel() }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
