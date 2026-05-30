<?php

namespace App\Filament\Resources\TestDummies;

use App\Filament\Resources\TestDummies\Pages\CreateTestDummy;
use App\Filament\Resources\TestDummies\Pages\EditTestDummy;
use App\Filament\Resources\TestDummies\Pages\ListTestDummies;
use App\Filament\Resources\TestDummies\Schemas\TestDummyForm;
use App\Filament\Resources\TestDummies\Tables\TestDummiesTable;
use App\Models\TestDummy;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TestDummyResource extends Resource
{
    protected static ?string $model = TestDummy::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TestDummyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TestDummiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTestDummies::route('/'),
            'create' => CreateTestDummy::route('/create'),
            'edit' => EditTestDummy::route('/{record}/edit'),
        ];
    }
}
