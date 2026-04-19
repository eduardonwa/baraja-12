<?php

namespace App\Filament\Resources\Ideas\Schemas;

use App\Filament\Resources\RotationCycles\RotationCycleResource;
use App\Models\Idea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class IdeaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('hook_id')
                    ->relationship('hook', 'name')
                    ->required(),
                TextInput::make('title')
                    ->label('Título')
                    ->required(),
                Textarea::make('description')
                    ->label('Descripción')
                    ->columnSpanFull(),
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
            ]);
    }
}
