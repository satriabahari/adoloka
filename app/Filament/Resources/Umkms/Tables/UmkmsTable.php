<?php

namespace App\Filament\Resources\Umkms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UmkmsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No.')
                    ->rowIndex()
                    ->alignCenter(),
                TextColumn::make('user.first_name')
                    ->placeholder('-')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->badge()
                    ->sortable()
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('city')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('latitude')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('longitude')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('halal_image')
                    ->collection('halal_verified')
                    ->conversion('thumb')
                    ->label('Halal Verified Image')
                    ->circular()
                    ->placeholder('-'),
                IconColumn::make('halal_verified')
                    ->placeholder('-')
                    ->boolean(),
                SpatieMediaLibraryImageColumn::make('bpom_image')
                    ->collection('bpom_verified')
                    ->conversion('thumb')
                    ->label('BPOM Verified Image')
                    ->circular()
                    ->placeholder('-'),
                IconColumn::make('bpom_verified')
                    ->placeholder('-')
                    ->boolean(),
                SpatieMediaLibraryImageColumn::make('nib_images')
                    ->collection('nib_verified')
                    ->conversion('thumb')
                    ->label('NIB Verified Image')
                    ->circular()
                    ->placeholder('-'),
                IconColumn::make('nib_verified')
                    ->placeholder('-')
                    ->boolean(),
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
