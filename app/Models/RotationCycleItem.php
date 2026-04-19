<?php

namespace App\Models;

use App\Models\ContentMetric;
use App\Models\Idea;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Validation\ValidationException;

class RotationCycleItem extends Model
{
    use HasFactory;

    protected $casts = [
        'done' => 'boolean',
        'completed_at' => 'datetime'
    ];

    protected static function booted(): void
    {
        static::created(function ($item) {
            $item->metric()->create([
                'rotation_cycle_item_id' => $item->id
            ]);
        });

        static::saving(function ($item) {
            if ($item->idea_id) {
                $idea = Idea::find($item->idea_id);

                if ($idea && $idea->hook_id !== $item->hook_id) {
                    throw ValidationException::withMessages([
                        'idea_id' => 'The selected idea does not belong to the same hook as this cycle item.'
                    ]);
                }
            }

            if ($item->done && !$item->completed_at) {
                $item->completed_at = now();
            }

            if (!$item->done) {
                $item->completed_at = null;
            }
        });

        static::saved(function ($item) {
            if ($item->idea_id && $item->metric) {
                $idea = $item->idea;

                if ($idea && blank($item->metric->title)) {
                    $item->metric->update([
                        'title' => $idea->title,
                    ]);
                }
            }

            // recalcular si el ciclo ya quedó terminado
            $item->cycle?->updateFinishedStatus();
        });

        static::deleted(function (RotationCycleItem $item) {
            $item->cycle?->updateFinishedStatus();
        });
    }

    public function cycle(): BelongsTo
    {
        return $this->belongsTo(RotationCycle::class, 'rotation_cycle_id');
    }

    public function hook(): BelongsTo
    {
        return $this->belongsTo(Hook::class, 'hook_id');
    }

    public function idea(): BelongsTo
    {
        return $this->belongsTo(Idea::class, 'idea_id');
    }

    public function metric(): HasOne
    {
        return $this->hasOne(ContentMetric::class, 'rotation_cycle_item_id');
    }
}
