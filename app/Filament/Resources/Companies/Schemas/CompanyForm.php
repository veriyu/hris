<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Company Details')
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
