<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No.')
                    ->rowIndex()
                    ->alignCenter(),
                TextColumn::make('order_number')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('user_id')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('purchasable_type')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('purchasable_id')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('item_name')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('unit_price')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('gross_amount')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('status')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('transaction_id')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('payment_type')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('paid_at')
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
