<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                SpatieMediaLibraryFileUpload::make('images')
                    ->collection('service')
                    ->label('Service Image')
                    ->image()
                    ->disk('public')
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state, '-'));
                    }),
                Textarea::make('description'),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(255),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('Rp'),
                TextInput::make('unit'),
                TextInput::make('consultation_link'),
                TextInput::make('revision_max')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('category_id')
                    ->required()
                    ->relationship('category', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),
                TextInput::make('delivery_days_min')
                    ->numeric(),
                TextInput::make('delivery_days_max')
                    ->numeric(),
                Toggle::make('has_brand_identity')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                Select::make('user_id')
                    ->required()
                    ->relationship('user', 'first_name')
                    ->required()
                    ->preload()
                    ->searchable(),
                Select::make('umkm_id')
                    ->required()
                    ->relationship('umkm', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),
            ]);
    }
}
