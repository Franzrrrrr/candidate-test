@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="flex items-center gap-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="px-3 py-2 text-gray-400 border border-gray-300 rounded-md cursor-not-allowed">
                        &lsaquo;
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" 
                       class="px-3 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-100 transition-colors" 
                       rel="prev" aria-label="@lang('pagination.previous')">
                        &lsaquo;
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true">
                        <span class="px-3 py-2 text-gray-400">...</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page">
                                <span class="px-3 py-2 bg-green-600 text-white border border-green-600 rounded-md">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" 
                                   class="px-3 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-100 transition-colors">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" 
                       class="px-3 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-100 transition-colors" 
                       rel="next" aria-label="@lang('pagination.next')">
                        &rsaquo;
                    </a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="px-3 py-2 text-gray-400 border border-gray-300 rounded-md cursor-not-allowed">
                        &rsaquo;
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
