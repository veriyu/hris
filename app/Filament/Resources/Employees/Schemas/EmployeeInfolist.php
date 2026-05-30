<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Models\Employee;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EmployeeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User')
                    ->placeholder('-'),
                TextEntry::make('company.name')
                    ->label('Company'),
                TextEntry::make('outlet.name')
                    ->label('Outlet'),
                TextEntry::make('department.name')
                    ->label('Department'),
                TextEntry::make('position.name')
                    ->label('Position'),
                TextEntry::make('supervisor.id')
                    ->label('Supervisor')
                    ->placeholder('-'),
                TextEntry::make('employee_number'),
                TextEntry::make('nik'),
                TextEntry::make('first_name'),
                TextEntry::make('last_name')
                    ->placeholder('-'),
                TextEntry::make('gender')
                    ->badge(),
                TextEntry::make('dob')
                    ->date(),
                TextEntry::make('join_date')
                    ->date(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('created_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('updated_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Employee $record): bool => $record->trashed()),
            ]);
    }
}
