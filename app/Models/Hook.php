<?php

namespace App\Models;

use App\Models\Idea;
use App\Models\RotationCycleItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hook extends Model
{
    use HasFactory;

    public function cycleItems(): HasMany
    {
        return $this->hasMany(RotationCycleItem::class);
    }

    public function ideas(): HasMany
    {
        return $this->hasMany(Idea::class);
    }
}
