<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatusResource\Pages\ListStatuses;
use App\Filament\Resources\StatusResource\StatusForm;
use App\Filament\Resources\StatusResource\StatusTable;
use App\Models\Status;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;

class StatusResource extends Resource
{
    protected static ?string $model = Status::class;

    protected static ?string $navigationGroup = 'Manage Tasks';

    protected static ?string $navigationLabel = 'Task Statuses';

    protected static ?string $modelLabel = 'Task Statuses';

    public static function form(Form $form): Form
    {
        return StatusForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return StatusTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStatuses::route('/'),
        ];
    }
}
