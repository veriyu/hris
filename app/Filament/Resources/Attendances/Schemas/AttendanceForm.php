<?php

namespace App\Filament\Resources\Attendances\Schemas;

use App\Enums\AttendanceStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('employee_id')
                    ->relationship('employee', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Employee $record) => "{$record->first_name} {$record->last_name} ({$record->employee_number})")
                    ->searchable()
                    ->required(),
                \Filament\Forms\Components\DatePicker::make('date')
                    ->required(),
                \Filament\Forms\Components\DateTimePicker::make('check_in')
                    ->required(),
                \Filament\Forms\Components\DateTimePicker::make('check_out'),
                \Filament\Forms\Components\Select::make('status')
                    ->options(\App\Enums\AttendanceStatus::class)
                    ->required()
                    ->default('Present'),
                \Filament\Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
