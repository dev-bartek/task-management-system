<?php

namespace App\Filament\Resources\TaskResource;

use App\Models\Task;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class TaskInfolist
{
    public static function make(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make()
                    ->schema([
                        TextEntry::make('title'),
                        TextEntry::make('description')
                            ->hidden(fn ($state) => is_null($state)),
                    ])->columnSpan(2),
                Group::make()->schema([
                    Section::make()
                        ->schema([
                            TextEntry::make('user.name'),
                        ]),
                    Section::make()
                        ->schema([
                            TextEntry::make('due_at')
                                ->label('Due Date')
                                ->inlineLabel()
                                ->date('d-m-Y'),
                            TextEntry::make('priority')
                                ->inlineLabel()
                                ->badge(),
                            IconEntry::make('completed')
                                ->inlineLabel()
                                ->boolean()
                                ->state(fn (Task $record) => $record->isCompleted()),
                            TextEntry::make('status.name')
                                ->label('Status')
                                ->inlineLabel()
                                ->badge()
                                ->color('primary'),
                        ]),
                ])->columnSpan(1),
            ])->columns(3);
    }
}
