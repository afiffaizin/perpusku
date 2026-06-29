@props(['title', 'subtitle' => null])

<div class="form-card">
    <h3 class="form-card-title">{{ $title }}</h3>
    @if($subtitle)
        <p class="form-card-subtitle">{{ $subtitle }}</p>
    @endif
    {{ $slot }}
</div>
