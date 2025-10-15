<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp.'),
                TextInput::make('stock')
                    ->required()
                    ->numeric(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
