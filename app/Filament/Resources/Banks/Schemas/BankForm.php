<?php

namespace App\Filament\Resources\Banks\Schemas;

use Filament\Schemas\Schema;

class BankForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Bank Details')
                    ->columns(2)
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }
}
