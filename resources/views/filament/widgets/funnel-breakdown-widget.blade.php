<x-filament-widgets::widget>
    <div class="funnel-breakdown">
        <h2 class="subheading"> {{ $subheading }} </h2>
        
        <div class="funnel-wrap">
            <div class="funnel-stage">
                <p class="funnel-label">
                    {{ $viewToProfileLabel }}
                </p>
                
                <strong>
                    {{ $viewToProfileValue }}
                </strong>
                
                <p class="funnel-description {{ $viewToProfileState }}">
                    <span class="lead">
                        {{ $viewToProfileLead }}
                    </span>
                    <span class="body">
                        {{ $viewToProfileBody }}
                    </span>
                </p>
            </div>

            <div class="funnel-stage">
                <p class="funnel-label">
                    {{ $profileToFollowLabel }}
                </p>
    
                <strong>
                    {{ $profileToFollowValue }}
                </strong>
    
                <p class="funnel-description {{ $profileToFollowState }}">
                    <span class="lead">
                        {{ $profileToFollowLead }}
                    </span>
                    <span class="body">
                        {{ $profileToFollowBody }}
                    </span>
                </p>
            </div>
        </div>

        @if ($topPost && $topPostUrl)
            <a
                class="funnel-top"
                href="{{ $topPostUrl }}"
                target="_blank"
                rel="noopener noreferrer"
            >
                Mejor desempeño: <strong>{{ $topPost }}</strong>
            </a>
        @endif
    </div>
</x-filament-widgets::widget>