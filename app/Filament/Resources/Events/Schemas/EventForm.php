<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('location')
                    ->required(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date')
                    ->required(),
                Select::make('type')
                    ->options(['mingguan' => 'Mingguan', 'tahunan' => 'Tahunan'])
                    ->required(),
                Select::make('category')
                    ->options(['UMKM Kuliner' => 'U m k m kuliner', 'UMKM Perkebunan' => 'U m k m perkebunan'])
                    ->required(),
                Toggle::make('is_strategic_location')
                    ->required(),
            ]);
    }
}
