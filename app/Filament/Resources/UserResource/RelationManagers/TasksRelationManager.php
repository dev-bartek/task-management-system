<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\TaskResource\TaskForm;
use App\Filament\Resources\TaskResource\TaskTable;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Table;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['user_id'] = $this->getOwnerRecord();

        return $data;
    }

    public function form(Form $form): Form
    {
        return TaskForm::make($form);
    }

    public function table(Table $table): Table
    {
        return TaskTable::make($table)
            ->recordTitleAttribute('title')
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
