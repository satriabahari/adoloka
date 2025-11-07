<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No.')
                    ->rowIndex()
                    ->alignCenter(),
                SpatieMediaLibraryImageColumn::make('images')
                    ->collection('user')
                    ->conversion('thumb')
                    ->label('Image')
                    ->circular()
                    ->placeholder('-'),
                TextColumn::make('first_name')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->icon('heroicon-m-envelope')
                    ->iconColor('info')
                    ->copyable()
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('google_id')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('role_id')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('-')
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
