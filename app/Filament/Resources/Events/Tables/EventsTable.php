<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('location')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('category')
                    ->badge(),
                IconColumn::make('is_strategic_location')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
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
