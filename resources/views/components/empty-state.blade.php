@props(['icon' => 'bi-inbox', 'title', 'description' => null, 'actionLabel' => null, 'actionRoute' => null])

<div class="empty-state">
    <div class="empty-icon"><i class="bi {{ $icon }}"></i></div>
    <h4 class="empty-title">{{ $title }}</h4>
    @if($description)
        <p class="empty-desc">{{ $description }}</p>
    @endif
    @if($actionLabel && $actionRoute)
        <a href="{{ $actionRoute }}" class="btn-primary-custom btn-sm-custom">
            <i class="bi bi-plus-lg"></i> {{ $actionLabel }}
        </a>
    @endif
</div>
