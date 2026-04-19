<x-filament-widgets::widget>
    <x-filament::section>
        <div class="volume-overview">
            <div class="volume-stats">
                <div class="stat">
                    <p class="label">Vistas promedio (7d)</p>
                    <p class="value">{{ $avgViews }}</p>
                </div>
                <div class="stat">
                    <p class="label">Visitas promedio al perfil</p>
                    <p class="value">{{ $avgProfileVisits }}</p>
                </div>

                <div class="stat">
                    <p class="label">Publicaciones analizadas</p>
                    <p class="value">{{ $totalPosts }}</p>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>