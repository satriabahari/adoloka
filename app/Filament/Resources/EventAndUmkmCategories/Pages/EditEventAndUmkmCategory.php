<?php

namespace App\Filament\Resources\EventAndUmkmCategories\Pages;

use App\Filament\Resources\EventAndUmkmCategories\EventAndUmkmCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEventAndUmkmCategory extends EditRecord
{
    protected static string $resource = EventAndUmkmCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
