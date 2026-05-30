<?php

namespace App\Filament\Resources\Outlets\Schemas;

use App\Models\Outlet;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OutletInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('company.name')
                    ->label('Company'),
                TextEntry::make('code'),
                TextEntry::make('name'),
                TextEntry::make('address')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Outlet $record): bool => $record->trashed()),
            ]);
    }
}
