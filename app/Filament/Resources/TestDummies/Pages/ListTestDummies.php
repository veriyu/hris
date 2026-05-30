<?php

namespace App\Filament\Resources\TestDummies\Pages;

use App\Filament\Resources\TestDummies\TestDummyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTestDummies extends ListRecords
{
    protected static string $resource = TestDummyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
