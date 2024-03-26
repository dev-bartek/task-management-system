<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages\CreateTask;
use App\Filament\Resources\TaskResource\Pages\EditTask;
use App\Filament\Resources\TaskResource\Pages\ListTasks;
use App\Filament\Resources\TaskResource\TaskForm;
use App\Filament\Resources\TaskResource\TaskInfolist;
use App\Filament\Resources\TaskResource\TaskTable;
use App\Models\Task;
use Filament\Forms\Form;
use Filament\Infolists\InfoList;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationGroup = 'Manage Tasks';

    public static function infolist(Infolist $infolist): Infolist
    {
        return TaskInfolist::make($infolist);
    }

    public static function form(Form $form): Form
    {
        return TaskForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return TaskTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'edit' => EditTask::route('/{record}/edit'),
        ];
    }
}
