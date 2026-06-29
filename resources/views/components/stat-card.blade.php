@props(['title', 'value', 'icon', 'color' => 'primary', 'trend' => null])

<div class="stat-card">
    <div>
        @if($trend)
            <span class="stat-trend {{ str_starts_with($trend, '+') ? 'up' : 'down' }}">
                <i class="bi {{ str_starts_with($trend, '+') ? 'bi-arrow-up-right' : 'bi-arrow-down-right' }}"></i>
                {{ $trend }}
            </span>
        @endif
        <div class="stat-value">{{ number_format($value) }}</div>
        <div class="stat-label">{{ $title }}</div>
    </div>
    <div class="stat-icon {{ $color }}">
        <i class="bi {{ $icon }}"></i>
    </div>
</div>
