<?php

namespace App\Models;

use App\Models\RotationCycleItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class ContentMetric extends Model
{
    protected $appends = [
        'view_to_profile_conversion_rate',
        'profile_visit_to_follow_conversion_rate',
        'likes_engagement_rate',
        'saves_engagement_rate',
        'comments_engagement_rate',
        'shares_engagement_rate',
        'reposts_engagement_rate',
        'total_engagement_rate',
    ];

    // RELATIONSHIPS
    
    public function rotationCycleItem(): BelongsTo
    {
        return $this->belongsTo(RotationCycleItem::class, 'rotation_cycle_item_id');
    }

    // FORMULAS

    protected function calculateRate($numerator, $denominator): float
    {
        $denominator = (float) $denominator;

        if ($denominator <= 0) {
            return 0.0;
        }

        return round(((float) $numerator / $denominator) * 100, 2);
    }

    // CONVERSION RATES

    public function getViewToProfileConversionRateAttribute(): float
    {
        return $this->calculateRate($this->profile_visits_7d, $this->views_7d);
    }

    public function getProfileVisitToFollowConversionRateAttribute(): float
    {
        return $this->calculateRate($this->follows_7d, $this->profile_visits_7d);
    }

    // ENGAGEMENT RATES

    public function getLikesEngagementRateAttribute(): float
    {
        return $this->calculateRate($this->likes_7d, $this->views_7d);
    }

    public function getSavesEngagementRateAttribute(): float
    {
        return $this->calculateRate($this->saves_7d, $this->views_7d);
    }

    public function getCommentsEngagementRateAttribute(): float
    {
        return $this->calculateRate($this->comments_7d, $this->views_7d);
    }

    public function getSharesEngagementRateAttribute(): float
    {
        return $this->calculateRate($this->shares_7d, $this->views_7d);
    }

    public function getRepostsEngagementRateAttribute(): float
    {
        return $this->calculateRate($this->reposts_7d, $this->views_7d);
    }

    public function getTotalEngagementRateAttribute(): float
    {
        $totalEngagement =
            (int) $this->likes_7d +
            (int) $this->comments_7d +
            (int) $this->shares_7d +
            (int) $this->saves_7d +
            (int) $this->reposts_7d;

        return $this->calculateRate($totalEngagement, $this->views_7d);
    }

    // SCOPES

    public function scopeWithConversionData(Builder $query): Builder
    {
        return $query
            ->where('views_7d', '>', 0)
            ->whereNotNull('profile_visits_7d')
            ->whereNotNull('follows_7d');
    }

    public function scopeWithEngagementData(Builder $query): Builder
    {
        return $query
            ->where('views_7d', '>', 0);
    }
}