<x-filament-widgets::widget>
    <div class="performance-summary">

        <div class="performance-card">
            <p class="label">Mejor publicación</p>
            <a href="{{ $bestPostUrl }}" target="_blank" rel="noopener noreferrer" class="idea">
                {{ $best?->title ?? 'Sin datos' }}
            </a> 
        </div>

        <div class="performance-card">
            <p class="label">Peor publicación</p>
            <a href="{{ $worstPostUrl }}" target="_blank" rel="noopener noreferrer" class="idea">
                {{ $worst?->title ?? 'Sin datos' }}
            </a>
        </div>

    </div>
</x-filament-widgets::widget>