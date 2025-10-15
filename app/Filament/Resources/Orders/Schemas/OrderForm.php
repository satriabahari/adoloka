<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_id')
                    ->required(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('product_id')
                    ->required()
                    ->numeric(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                TextInput::make('payment_type'),
                Textarea::make('midtrans_response')
                    ->columnSpanFull(),
                DateTimePicker::make('paid_at'),
            ]);
    }
}
