<?php

namespace App\Filament\Resources\EventAndUmkmCategories;

use App\Filament\Resources\EventAndUmkmCategories\Pages\CreateEventAndUmkmCategory;
use App\Filament\Resources\EventAndUmkmCategories\Pages\EditEventAndUmkmCategory;
use App\Filament\Resources\EventAndUmkmCategories\Pages\ListEventAndUmkmCategories;
use App\Filament\Resources\EventAndUmkmCategories\Schemas\EventAndUmkmCategoryForm;
use App\Filament\Resources\EventAndUmkmCategories\Tables\EventAndUmkmCategoriesTable;
use App\Models\EventAndUmkmCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EventAndUmkmCategoryResource extends Resource
{
    protected static ?string $model = EventAndUmkmCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingStorefront;

    protected static string|UnitEnum|null $navigationGroup = "Categories";

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Total Event and Umkm Categories';
    }

    public static function form(Schema $schema): Schema
    {
        return EventAndUmkmCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventAndUmkmCategoriesTable::configure($table);
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
            'index' => ListEventAndUmkmCategories::route('/'),
            'create' => CreateEventAndUmkmCategory::route('/create'),
            'edit' => EditEventAndUmkmCategory::route('/{record}/edit'),
        ];
    }
}
