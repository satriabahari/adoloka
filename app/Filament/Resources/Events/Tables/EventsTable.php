<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No.')
                    ->rowIndex()
                    ->alignCenter(),
                SpatieMediaLibraryImageColumn::make('images')
                    ->collection('event')
                    ->conversion('thumb')
                    ->label('Image')
                    ->circular()
                    ->placeholder('-'),
                TextColumn::make('title')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('slug')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('latitude')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('longitude')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('start_date')
                    ->date()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->placeholder('-'),
                TextColumn::make('categories.name')
                    ->label('Categories')
                    ->badge()
                    ->limitList(3)
                    ->listWithLineBreaks(),
                IconColumn::make('is_strategic_location')
                    ->boolean()
                    ->placeholder('-'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
