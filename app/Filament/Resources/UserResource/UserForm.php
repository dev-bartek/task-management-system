<?php

namespace App\Filament\Resources\UserResource;

use App\Enums\UserType;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->string()
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(),
                        TextInput::make('password')
                            ->hidden(fn (string $operation): bool => $operation === 'view')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->rule(Password::default()),
                        TextInput::make('confirm_password')
                            ->hidden(fn (string $operation): bool => $operation === 'view')
                            ->label('Confirm Password')
                            ->password()
                            ->same('password')
                            ->requiredWith('password'),
                    ])->columnSpan(2),
                Section::make()
                    ->schema([
                        Select::make('type')
                            ->required()
                            ->options(
                                array_combine(
                                    UserType::values(),
                                    UserType::names()
                                )),
                    ])->columnSpan(1),
            ])->columns(3);
    }
}
