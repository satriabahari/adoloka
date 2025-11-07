<?php

namespace App\Filament\Resources\EventAndUmkmCategories\Pages;

use App\Filament\Resources\EventAndUmkmCategories\EventAndUmkmCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEventAndUmkmCategory extends CreateRecord
{
    protected static string $resource = EventAndUmkmCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
