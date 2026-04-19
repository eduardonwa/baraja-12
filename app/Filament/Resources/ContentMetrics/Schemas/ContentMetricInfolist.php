<?php

namespace App\Filament\Resources\ContentMetrics\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContentMetricInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Calculated metrics')
                    ->schema([
                        TextEntry::make('view_to_profile_conversion_rate')
                            ->label('Views → Profile')
                            ->formatStateUsing(fn ($state) => number_format((float) $state, 2) . '%'),

                        TextEntry::make('profile_visit_to_follow_conversion_rate')
                            ->label('Profile → Follow')
                            ->formatStateUsing(fn ($state) => number_format((float) $state, 2) . '%'),

                        TextEntry::make('likes_engagement_rate')
                            ->label('Likes Engagement')
                            ->formatStateUsing(fn ($state) => number_format((float) $state, 2) . '%'),

                        TextEntry::make('saves_engagement_rate')
                            ->label('Saves Engagement')
                            ->formatStateUsing(fn ($state) => number_format((float) $state, 2) . '%'),

                        TextEntry::make('comments_engagement_rate')
                            ->label('Comments Engagement')
                            ->formatStateUsing(fn ($state) => number_format((float) $state, 2) . '%'),

                        TextEntry::make('shares_engagement_rate')
                            ->label('Shares Engagement')
                            ->formatStateUsing(fn ($state) => number_format((float) $state, 2) . '%'),

                        TextEntry::make('reposts_engagement_rate')
                            ->label('Reposts Engagement')
                            ->formatStateUsing(fn ($state) => number_format((float) $state, 2) . '%'),

                        TextEntry::make('total_engagement_rate')
                            ->label('Total Engagement')
                            ->formatStateUsing(fn ($state) => number_format((float) $state, 2) . '%'),
                    ])->columns(2),
                Section::make('Raw metrics')
                    ->schema([
                        TextEntry::make('title')
                            ->placeholder('-'),
                        TextEntry::make('type')
                            ->placeholder('-'),
                        TextEntry::make('format')
                            ->placeholder('-'),
                        TextEntry::make('people_tagged_and_dmd')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('hashtags_used')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('accounts_reached')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('profile_visits')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('follows')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('likes')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('comments')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('shares')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('saves')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('reposts')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('views')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])->columns(2),
            ]);
    }
}
