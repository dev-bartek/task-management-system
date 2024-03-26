<?php

namespace App\Filament\Resources\StatusResource;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class StatusForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->string()
                    ->maxLength(255)
                    ->unique(),
            ]);
    }
}
