<?php

namespace App\Models;

use App\Models\Hook;
use App\Models\RotationCycleItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Idea extends Model
{
    use HasFactory;

    public function hook(): BelongsTo
    {
        return $this->belongsTo(Hook::class);
    }

    public function cycleItems(): HasMany
    {
        return $this->hasMany(RotationCycleItem::class);
    }

    public function getCycleNamesAttribute(): string
    {
        return $this->cycleItems
            ->loadMissing('cycle')
            ->pluck('cycle.name')
            ->filter()
            ->unique()
            ->join(', ');
    }
}
