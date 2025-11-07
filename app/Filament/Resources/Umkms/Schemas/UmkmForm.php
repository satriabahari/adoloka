<?php

namespace App\Filament\Resources\Umkms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UmkmForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'first_name')
                    ->required()
                    ->preload()
                    ->searchable(),
                TextInput::make('name')
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),
                TextInput::make('city')
                    ->required(),
                TextInput::make('latitude')
                    ->numeric(),
                TextInput::make('longitude')
                    ->numeric(),
                Textarea::make('address')
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('halal_image')
                    ->collection('halal_verified')
                    ->label('Halal Verified Image')
                    ->image()
                    ->disk('public')
                    ->columnSpanFull(),
                Toggle::make('halal_verified')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('bpom_image')
                    ->collection('bpom_verified')
                    ->label('BPOM Verified Image')
                    ->image()
                    ->disk('public')
                    ->columnSpanFull(),
                Toggle::make('bpom_verified')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('nib_image')
                    ->collection('nib_verified')
                    ->label('NIB Verified Image')
                    ->image()
                    ->disk('public')
                    ->columnSpanFull(),
                Toggle::make('nib_verified')
                    ->required(),
            ]);
    }
}
