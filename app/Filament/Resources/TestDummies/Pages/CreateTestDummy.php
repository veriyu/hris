<?php

namespace App\Filament\Resources\TestDummies\Pages;

use App\Filament\Resources\TestDummies\TestDummyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTestDummy extends CreateRecord
{
    protected static string $resource = TestDummyResource::class;
}
