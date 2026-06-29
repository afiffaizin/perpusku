@props(['title' => null, 'subtitle' => null])

<div class="content-card">
    @if($title)
        <div class="card-header-custom">
            <div>
                <h3 class="card-title">{{ $title }}</h3>
                @if($subtitle)
                    <p class="card-subtitle">{{ $subtitle }}</p>
                @endif
            </div>
            @if(isset($actions))
                <div class="d-flex align-items-center gap-2">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif
    @if(isset($filters))
        <div class="table-filter-bar">
            {{ $filters }}
        </div>
    @endif
    <div class="data-table-wrapper">
        <table class="data-table">
            @if(isset($thead))
                <thead>{{ $thead }}</thead>
            @endif
            <tbody>{{ $slot }}</tbody>
        </table>
    </div>
    @if(isset($pagination))
        <div class="table-pagination">
            {{ $pagination }}
        </div>
    @endif
</div>
