@props(['items' => []])

@if(count($items) > 0)
<nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
        <ol class="breadcrumb">
            @foreach($items as $index => $item)
                @if($index === count($items) - 1)
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $item['name'] }}
                    </li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{{ $item['url'] ?? '#' }}" class="text-decoration-none">
                            {{ $item['name'] }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ol>
    </div>
</nav>

<!-- Breadcrumb Structured Data -->
<script type="application/ld+json">
{!! json_encode(\App\Http\Controllers\SeoController::getBreadcrumbStructuredData($items), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endif
