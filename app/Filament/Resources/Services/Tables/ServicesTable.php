<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No.')
                    ->rowIndex()
                    ->alignCenter(),
                SpatieMediaLibraryImageColumn::make('images')
                    ->collection('service')
                    ->conversion('thumb')
                    ->label('Image')
                    ->circular()
                    ->placeholder('-'),
                TextColumn::make('name')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('slug')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('price')
                    ->money("IDR")
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('unit')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('consultation_link')
                    ->icon('heroicon-m-chat-bubble-oval-left-ellipsis')
                    ->iconColor('info')
                    ->copyable()
                    ->placeholder('-')
                    ->searchable(),
                IconColumn::make('has_brand_identity')
                    ->placeholder('-')
                    ->boolean(),
                TextColumn::make('revision_max')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('delivery_days_min')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('delivery_days_max')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->placeholder('-')
                    ->boolean(),
                TextColumn::make('category.name')
                    ->badge()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('user.first_name')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('umkm.name')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
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
