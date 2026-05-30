<?php

namespace App\Filament\Resources\TestDummies\Schemas;

use Filament\Schemas\Schema;

class TestDummyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
