<nav class="mt-3 mb-4" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/" class="text-decoration-none">Home</a>
        </li>
        
        @foreach($items as $key => $item)
            @if($loop->last)
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $item['label'] }}
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}" class="text-decoration-none">{{ $item['label'] }}</a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
