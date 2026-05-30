<?php

namespace App\Filament\Resources\TestDummies\Pages;

use App\Filament\Resources\TestDummies\TestDummyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTestDummy extends EditRecord
{
    protected static string $resource = TestDummyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
