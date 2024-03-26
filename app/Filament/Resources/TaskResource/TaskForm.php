<?php

namespace App\Filament\Resources\TaskResource;

use App\Enums\TaskPriority;
use App\Filament\Resources\UserResource\RelationManagers\TasksRelationManager;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class TaskForm
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->string()
                            ->maxLength(255),
                        TextArea::make('description')
                            ->string()
                            ->nullable()
                            ->maxLength(1000),
                    ])->columnSpan(2),
                Section::make()
                    ->schema([
                        DatePicker::make('due_at')
                            ->label('Due Date')
                            ->date(),
                        Select::make('priority')
                            ->required()
                            ->options(
                                array_combine(
                                    TaskPriority::values(),
                                    TaskPriority::names()
                                )),
                        Select::make('user_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship(name: 'user', titleAttribute: 'name')
                            ->hiddenOn(TasksRelationManager::class),
                        Select::make('status_id')
                            ->nullable()
                            ->preload()
                            ->relationship(name: 'status', titleAttribute: 'name'),
                    ])->columnSpan(1),
            ])->columns(3);
    }
}
