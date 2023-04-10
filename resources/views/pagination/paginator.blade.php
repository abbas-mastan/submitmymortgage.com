@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <ul class="pagination flex">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link bg-white text-gray-600 hover:text-gray-800 hover:bg-gray-100  px-3 py-2 mx-1 transition-colors duration-150 ease-in-out"
                        data-href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        aria-label="{{ __('pagination.previous') }}">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span
                            class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span
                                    class="page-link bg-blue-500 text-white font-bold px-3 py-2 mx-1">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item"><a
                                    class="page-link bg-white text-gray-600 hover:text-gray-800 hover:bg-gray-100 border border-gray-300  px-3 py-2 mx-1 transition-colors duration-150 ease-in-out focus:outline-none focus:shadow-outline"
                                    data-href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link bg-white text-gray-600 hover:text-gray-800 hover:bg-gray-100 px-3 py-2 mx-1 transition-colors duration-150 ease-in-out focus:outline-none"
                        data-href="{{ $paginator->nextPageUrl() }}" rel="next"
                        aria-label="{{ __('pagination.next') }}">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
