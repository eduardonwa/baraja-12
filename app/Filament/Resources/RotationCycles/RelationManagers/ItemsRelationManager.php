<?php

namespace App\Filament\Resources\RotationCycles\RelationManagers;

use App\Filament\Resources\ContentMetrics\ContentMetricResource;
use App\Models\Idea;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Combos';

    // protected static ?string $modelLabel = 'combinación';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('current_hook_name')
                    ->label('Hook')
                    ->state(fn ($record) => $record?->hook?->name ?? '-'),
                TextEntry::make('current_hook_description')
                    ->label('Descripción')
                    ->state(fn ($record) => $record?->hook?->description ?? '-'),
                Select::make('idea_id')
                    ->label('Idea')
                    ->options(function ($record) {
                        if (!$record) {
                            return [];
                        }
                        return Idea::query()
                            ->where('hook_id', $record->hook_id)
                            ->orderBy('title')
                            ->pluck('title', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->createOptionForm(function ($record) {
                        return [
                            TextEntry::make('create_hook_name')
                                ->label('Hook')
                                ->state($record?->hook?->name ?? '-'),
                            TextEntry::make('create_hook_description')
                                ->label('Descripción')
                                ->state($record?->hook?->description ?? '-'),
                            TextInput::make('title')
                                ->label('Título')
                                ->required()
                                ->maxLength(255),
                            Textarea::make('description')
                                ->label('Descripción')
                                ->rows(3),
                        ];
                    })
                    ->createOptionUsing(function (array $data, $record) {
                        // Crea una nueva idea utilizando los datos proporcionados y el hook_id heredado del registro actual
                        return Idea::create([
                            'title' => $data['title'],
                            'description' => $data['description'] ?? null,
                            'hook_id' => $record->hook_id, // hook_id del registro actual
                        ])->id;
                    }),
                Toggle::make('done')
                    ->label('Terminado')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('position')
                    ->label('Posición')
                    ->sortable(),
                TextColumn::make('hook.name')
                    ->label('Hook')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('idea.title')
                    ->label('Idea')
                    ->placeholder('-')
                    ->searchable(),
                IconColumn::make('done')
                    ->label('Estado')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('completed_at')
                    ->label('Completado el')
                    ->dateMex()
                    ->placeholder('-'),
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Editar combo')
                    ->modalHeading('Editar combinación')
                    ->modalSubmitActionLabel('Guardar cambios')
                    ->modalCancelActionLabel('Cancelar'),
                Action::make('editIdea')
                    ->label('Editar idea')
                    ->icon('heroicon-o-pencil-square')
                    ->visible(fn ($record) => filled($record->idea_id))
                    ->fillForm(fn ($record) => [
                        'title' => $record->idea?->title,
                        'description' => $record->idea?->description,
                    ])
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Descripción')
                            ->rows(3),
                    ])
                    ->action(function (array $data, $record): void {
                        if (! $record->idea) {
                            return;
                        }

                        $record->idea->update([
                            'title' => $data['title'],
                            'description' => $data['description'] ?? null
                        ]);
                    })
                    ->slideOver(),
                Action::make('editContentMetric')
                    ->label('Editar métrica')
                    ->icon('heroicon-o-chart-bar-square')
                    ->url(fn ($record) => $record->metric
                        ? ContentMetricResource::geturl('edit', ['record' => $record->metric])
                        : null)
                    ->openUrlInNewTab()
            ]);
    }
}
