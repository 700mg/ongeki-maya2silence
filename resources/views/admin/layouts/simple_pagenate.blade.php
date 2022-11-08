@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-right">
        <div class="flex-fill d-flex align-items-center justify-content-center">
            <div>
                <ul class="pagination align-items-center m-1">
                    {{-- First Page View --}}
                    <li class="page-item {{ $paginator->onFirstPage() ? ' disabled' : '' }}">
                        <a class="page-link" href="{{ $paginator->url(1) }}">&laquo;</a>
                    </li>

                    {{-- Previous Page Link --}}
                    <li class="page-item {{ $paginator->onFirstPage() ? ' disabled' : '' }}">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}">&lsaquo;</a>
                    </li>

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        {{--@if (is_string($element))
                            <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                        @endif--}}

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="active" aria-current="page"><span class="p-2">&nbsp;{{ $page }}</span></li>
                                    <span>/</span>
                                    <li class="active" aria-current="page">
                                        <span class="p-2">{{ $paginator->lastPage() }}&nbsp;</span>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    <li class="page-item {{ $paginator->currentPage() == $paginator->lastPage() ? ' disabled' : '' }}">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">&rsaquo;</a>
                    </li>

                    {{-- Last Page Link --}}
                    <li class="page-item {{ $paginator->currentPage() == $paginator->lastPage() ? ' disabled' : '' }}">
                        <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">&raquo;</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
@endif
