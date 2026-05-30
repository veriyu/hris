<?php

namespace App\Filament\Resources\Outlets;

use App\Filament\Resources\Outlets\Pages\CreateOutlet;
use App\Filament\Resources\Outlets\Pages\EditOutlet;
use App\Filament\Resources\Outlets\Pages\ListOutlets;
use App\Filament\Resources\Outlets\Pages\ViewOutlet;
use App\Filament\Resources\Outlets\Schemas\OutletForm;
use App\Filament\Resources\Outlets\Schemas\OutletInfolist;
use App\Filament\Resources\Outlets\Tables\OutletsTable;
use App\Models\Outlet;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OutletResource extends Resource
{
    protected static ?string $model = Outlet::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-building-storefront';
    protected static \UnitEnum|string|null $navigationGroup = 'Organization';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OutletForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OutletInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OutletsTable::configure($table);
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
            'index' => ListOutlets::route('/'),
            'create' => CreateOutlet::route('/create'),
            'view' => ViewOutlet::route('/{record}'),
            'edit' => EditOutlet::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
