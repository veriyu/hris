<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Enums\EmployeeStatus;
use App\Enums\Gender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Tabs::make('Tabs')
                    ->tabs([
                        \Filament\Schemas\Components\Tabs\Tab::make('Personal Information')
                            ->schema([
                                TextInput::make('nik')
                                    ->label('NIK / ID Card')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                TextInput::make('first_name')
                                    ->required(),
                                TextInput::make('last_name'),
                                Select::make('gender')
                                    ->options(Gender::class)
                                    ->required(),
                                DatePicker::make('dob')
                                    ->label('Date of Birth')
                                    ->required(),
                            ])->columns(2),
                        \Filament\Schemas\Components\Tabs\Tab::make('Employment Information')
                            ->schema([
                                TextInput::make('employee_number')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->visibleOn('edit'),
                                Select::make('status')
                                    ->options(EmployeeStatus::class)
                                    ->default(EmployeeStatus::ACTIVE)
                                    ->required(),
                                DatePicker::make('join_date')
                                    ->required(),
                                Select::make('company_id')
                                    ->relationship('company', 'name')
                                    ->required(),
                                Select::make('outlet_id')
                                    ->relationship('outlet', 'name')
                                    ->required(),
                                Select::make('department_id')
                                    ->relationship('department', 'name')
                                    ->required(),
                                Select::make('position_id')
                                    ->relationship('position', 'name')
                                    ->required(),
                                Select::make('supervisor_id')
                                    ->relationship('supervisor', 'first_name')
                                    ->searchable()
                                    ->preload(),
                            ])->columns(2),
                        \Filament\Schemas\Components\Tabs\Tab::make('Financial Information')
                            ->schema([
                                Select::make('bank_id')
                                    ->relationship('bank', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->label('Bank Name'),
                                TextInput::make('bank_account_number')
                                    ->label('Account Number'),
                                TextInput::make('bank_account_name')
                                    ->label('Account Name'),
                            ])->columns(2),
                    ])->columnSpanFull()
            ]);
    }
}
