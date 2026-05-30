<?php

namespace App\Filament\Resources\Positions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Position Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('code')
                            ->required(),
                        TextInput::make('name')
                            ->required(),
                    ]),
            ]);
    }
}
