<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_number')
                    ->required(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('purchasable_type')
                    ->required(),
                TextInput::make('purchasable_id')
                    ->required()
                    ->numeric(),
                TextInput::make('item_name')
                    ->required(),
                TextInput::make('unit_price')
                    ->required()
                    ->numeric(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('gross_amount')
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('waiting_payment'),
                TextInput::make('transaction_id'),
                TextInput::make('payment_type'),
                DateTimePicker::make('paid_at'),
                TextInput::make('meta'),
            ]);
    }
}
