<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No.')
                    ->rowIndex()
                    ->alignCenter(),
                SpatieMediaLibraryImageColumn::make('images')
                    ->collection('product')
                    ->conversion('thumb')
                    ->label('Image')
                    ->circular()
                    ->placeholder('-'),
                TextColumn::make('name')
                    ->placeholder('-')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('price')
                    ->money('IDR')
                    ->placeholder('-'),
                TextColumn::make('stock')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->placeholder('-'),
                TextColumn::make('category.name')
                    ->badge()
                    ->sortable()
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('umkm.name')
                    ->placeholder('-')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.first_name')
                    ->placeholder('-')
                    ->sortable()
                    ->searchable(),
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
