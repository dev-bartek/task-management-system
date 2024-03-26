<?php

namespace App\Filament\Resources\UserResource;

use App\Enums\UserType;
use App\Models\User;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UserTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(isIndividual: true),
                TextColumn::make('type')
                    ->label('type')
                    ->sortable()
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(array_combine(UserType::values(), UserType::names())),
            ])
            ->actions([
                ViewAction::make()
                    ->iconButton(),
                EditAction::make()
                    ->iconButton(),
                DeleteAction::make()
                    ->iconButton()
                    ->hidden(User::where('type', UserType::Admin)->count() === 1),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
