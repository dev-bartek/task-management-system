<?php

namespace App\Filament\Resources\TaskResource;

use App\Enums\TaskPriority;
use App\Filament\Resources\UserResource\RelationManagers\TasksRelationManager;
use App\Models\Task;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TaskTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->hiddenOn(TasksRelationManager::class),
                TextColumn::make('due_at')
                    ->label('Task Due')
                    ->sortable()
                    ->date('d-m-Y'),
                IconColumn::make('completed')
                    ->state(fn (Task $record) => $record->isCompleted())
                    ->boolean(),
                TextColumn::make('status.name')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('priority')
                    ->label('Priority')
                    ->sortable()
                    ->badge(),
                TextColumn::make('completed_at')
                    ->sortable()
                    ->date('d-m-Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->relationship('user', 'name'),
                SelectFilter::make('priority')
                    ->options(array_combine(TaskPriority::values(), TaskPriority::names())),
            ])
            ->actions([
                Action::make('Complete Task')
                    ->hidden(fn (Task $record) => $record->isCompleted())
                    ->icon('heroicon-o-check-circle')
                    ->iconButton()
                    ->action(fn (Task $record) => $record->complete())
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Task Completed!'),
                    ),
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
