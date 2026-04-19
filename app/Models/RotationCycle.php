<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RotationCycle extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean',
        'is_finished' => 'boolean'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(RotationCycleItem::class)->orderBy('position');
    }

    public function updateFinishedStatus(): void
    {
        $hasItems = $this->items()->exists();

        // si no tiene items, no puede estar "terminado"
        if (! $hasItems) {
            $this->updateQuietly([
                'is_finished' => false
            ]);
            
            return;
        }

        // "pendiente" es: si un item tiene "done" como false
        $hasPending = $this->items()
            ->where('done', false)
            ->exists();
        
        // "terminado" no es igual a "pendiente"
        $this->updateQuietly([
            'is_finished' => ! $hasPending
        ]);
    }
}