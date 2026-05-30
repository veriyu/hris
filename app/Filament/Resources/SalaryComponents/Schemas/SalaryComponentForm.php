<?php

namespace App\Filament\Resources\SalaryComponents\Schemas;

use App\Enums\SalaryComponentType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SalaryComponentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                \Filament\Forms\Components\Select::make('type')
                    ->options(\App\Enums\SalaryComponentType::class)
                    ->required(),
                \Filament\Forms\Components\Toggle::make('is_default')
                    ->required(),
            ]);
    }
}
