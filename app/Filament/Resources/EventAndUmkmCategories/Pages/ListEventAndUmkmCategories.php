<?php

namespace App\Filament\Resources\EventAndUmkmCategories\Pages;

use App\Filament\Resources\EventAndUmkmCategories\EventAndUmkmCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventAndUmkmCategories extends ListRecords
{
    protected static string $resource = EventAndUmkmCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
