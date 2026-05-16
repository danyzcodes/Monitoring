@if ($paginator->hasPages())
<div class="flex items-center justify-between gap-4
            px-4 py-3 rounded-2xl
            bg-slate-50 border border-slate-200
            text-sm text-slate-600">

    
    <div class="hidden sm:block">
        Menampilkan
        <span class="font-medium text-slate-900">
            {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}
        </span>
        dari
        <span class="font-medium text-slate-900">
            {{ $paginator->total() }}
        </span>
        data
    </div>

    
    <nav class="flex items-center gap-1">

        
        @if ($paginator->onFirstPage())
            <span
                class="w-8 h-8 flex items-center justify-center
                       rounded-full text-slate-400 cursor-not-allowed">
                ‹
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="w-8 h-8 flex items-center justify-center
                      rounded-full text-slate-600
                      hover:bg-white hover:shadow transition">
                ‹
            </a>
        @endif

        
        @foreach ($elements as $element)

            @if (is_string($element))
                <span class="w-8 h-8 flex items-center justify-center text-slate-400">
                    …
                </span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            class="w-8 h-8 flex items-center justify-center
                                   rounded-full bg-slate-800 text-white
                                   text-xs font-semibold shadow">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="w-8 h-8 flex items-center justify-center
                                  rounded-full text-slate-600 text-xs
                                  hover:bg-white hover:shadow transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif

        @endforeach

        
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="w-8 h-8 flex items-center justify-center
                      rounded-full text-slate-600
                      hover:bg-white hover:shadow transition">
                ›
            </a>
        @else
            <span
                class="w-8 h-8 flex items-center justify-center
                       rounded-full text-slate-400 cursor-not-allowed">
                ›
            </span>
        @endif

    </nav>
</div>
@endif
