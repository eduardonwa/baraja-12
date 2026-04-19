<?php

namespace App\Filament\Resources\ContentMetrics\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ContentMetricForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Publicación')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título'),

                        Select::make('type')
                            ->label('Tipo')
                            ->options([
                                'image' => 'Imagen',
                                'reel' => 'Reel',
                                'carousel' => 'Carrusel',
                            ]),

                        Select::make('format')
                            ->options([
                                'meme' => 'Meme',
                                'updates' => 'Noticias',
                                'story' => 'Story',
                            ]),

                        Textarea::make('hashtags_used')
                            ->label('Etiquetas')
                            ->columnSpanFull(),

                        Textarea::make('people_tagged_and_dmd')
                            ->label('Cuentas etiquetadas y contactadas')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Registro de métricas')
                    ->schema([
                        Tabs::make('MetricsTabs')
                            ->tabs([
                                Tab::make('Impacto inicial (24h)')
                                    ->schema([
                                        TextInput::make('views_24h')
                                            ->label('Vistas')
                                            ->numeric(),
                                        TextInput::make('profile_visits_24h')
                                            ->label('Visitas al perfil')
                                            ->numeric(),
                                        TextInput::make('follows_24h')
                                            ->label('Nuevos seguidores')
                                            ->numeric(),
                                        TextInput::make('likes_24h')
                                            ->label('Me gusta')
                                            ->numeric(),
                                        TextInput::make('comments_24h')
                                            ->label('Comentarios')
                                            ->numeric(),
                                        TextInput::make('shares_24h')
                                            ->label('Compartidos')
                                            ->numeric(),
                                        TextInput::make('saves_24h')
                                            ->label('Guardados')
                                            ->numeric(),
                                        TextInput::make('reposts_24h')
                                            ->label('Reposts')
                                            ->numeric(),
                                    ])
                                    ->columns(2),

                                Tab::make('Fase de validación (3d)')
                                    ->schema([
                                        TextInput::make('views_3d')
                                            ->label('Vistas')
                                            ->numeric(),
                                        TextInput::make('profile_visits_3d')
                                            ->label('Visitas al perfil')
                                            ->numeric(),
                                        TextInput::make('follows_3d')
                                            ->label('Nuevos seguidores')
                                            ->numeric(),
                                        TextInput::make('likes_3d')
                                            ->label('Me gusta')
                                            ->numeric(),
                                        TextInput::make('comments_3d')
                                            ->label('Comentarios')
                                            ->numeric(),
                                        TextInput::make('shares_3d')
                                            ->label('Compartidos')
                                            ->numeric(),
                                        TextInput::make('saves_3d')
                                            ->label('Guardados')
                                            ->numeric(),
                                        TextInput::make('reposts_3d')
                                            ->label('Reposts')
                                            ->numeric(),
                                    ])
                                    ->columns(2),

                                Tab::make('Rendimiento final (7d)')
                                    ->schema([
                                        TextInput::make('views_7d')
                                            ->label('Vistas')
                                            ->numeric(),
                                        TextInput::make('profile_visits_7d')
                                            ->label('Visitas al perfil')
                                            ->numeric(),
                                        TextInput::make('follows_7d')
                                            ->label('Nuevos seguidores')
                                            ->numeric(),
                                        TextInput::make('likes_7d')
                                            ->label('Me gusta')
                                            ->numeric(),
                                        TextInput::make('comments_7d')
                                            ->label('Comentarios')
                                            ->numeric(),
                                        TextInput::make('shares_7d')
                                            ->label('Compartidos')
                                            ->numeric(),
                                        TextInput::make('saves_7d')
                                            ->label('Guardados')
                                            ->numeric(),
                                        TextInput::make('reposts_7d')
                                            ->label('Reposts')
                                            ->numeric(),
                                    ])
                                    ->columns(2),
                            ])
                            ->columnSpanFull(),
                    ]),

                Select::make('rotation_cycle_item_id')
                    ->relationship('rotationCycleItem', 'id')
                    ->required()
                    ->hidden(),
            ]);
    }
}