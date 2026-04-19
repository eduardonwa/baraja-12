<?php

namespace App\Filament\Resources\Ideas\Tables;

use App\Filament\Resources\RotationCycles\RotationCycleResource;
use App\Models\Idea;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class IdeasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('hook.name')
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Fecha creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Fecha actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->modalHeading('Editar idea')
                    ->schema([
                        Select::make('hook_id')
                            ->label('Hook')
                            ->relationship('hook', 'name')
                            ->required(),
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(5)
                            ->autosize(),
                        TextEntry::make('cycle_links')
                            ->label('Sets')
                            ->inlineLabel()
                            ->state(function (?Idea $record) {
                                if (! $record) {
                                    return 'Sin ciclo';
                                }

                                $cycles = $record->cycleItems
                                    ->loadMissing('cycle')
                                    ->pluck('cycle')
                                    ->filter()
                                    ->unique('id');

                                if ($cycles->isEmpty()) {
                                    return 'Sin ciclo';
                                }

                                return new HtmlString(
                                    $cycles
                                        ->map(fn ($cycle) => sprintf(
                                            '<a href="%s" class="text-primary-600 underline">%s</a>',
                                            RotationCycleResource::getUrl('edit', ['record' => $cycle]),
                                            e($cycle->name)
                                        ))
                                        ->join('<br>')
                                );
                            })
                    ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
