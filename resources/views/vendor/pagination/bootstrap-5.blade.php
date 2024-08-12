@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        
        <style>
            /* Estilos personalizados para a paginação */
            .pagination-custom {
                background-color: #f8f9fa;
                color: #6c757d;
                border-color: #e9ecef;
            }
            .pagination-custom .page-link {
                background-color: #f8f9fa;
                color: #6c757d;
            }
            .pagination-custom .page-item.disabled .page-link {
                background-color: #e9ecef;
                color: #adb5bd;
            }
            .pagination-custom .page-item.active .page-link {
                background-color: #6c757d;
                color: #fff;
                border-color: #4b5154;
            }
            .pagination-custom .page-item .page-link:focus {
                box-shadow: 0 0 0 0.2rem #6c757d61;
                outline: none;
            }
        </style>

        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination pagination-custom">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <div>
                <p class="small text-muted">
                    {!! __('Mostrando') !!}
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    {!! __('até') !!}
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    {!! __('de') !!}
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    {!! __('registros') !!}
                </p>
            </div>

            <div>
                <ul class="pagination pagination-custom">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
