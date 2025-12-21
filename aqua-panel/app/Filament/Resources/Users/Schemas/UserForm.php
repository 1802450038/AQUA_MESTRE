<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                TextInput::make('email')
                    ->label('Endereço de email')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(fn(string $operation): bool => $operation === 'create'),
                TextInput::make('password_confirmation')
                    ->password()
                    ->required(fn(string $operation): bool => $operation === 'create'),
                Select::make('role')
                    ->label('Função')
                    ->options([
                        'admin' => 'Admin',
                        'manager' => 'Gerente',
                        'user' => 'Usuário',
                    ])
                    ->required()
                    ->default('user')
                    ->hidden(fn(): bool => !auth()->user()->isAdmin()),
                Toggle::make('is_dark_mode')
                    ->required(),
            ]);
    }
}
