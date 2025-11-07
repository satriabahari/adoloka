<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name'),
                Textarea::make('about')
                    ->columnSpanFull(),
                TextInput::make('phone_number')
                    ->tel(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('google_id'),
                Select::make('role_id')
                    ->label("Role")
                    ->relationship('role', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),
                DateTimePicker::make('email_verified_at'),
            ]);
    }
}
