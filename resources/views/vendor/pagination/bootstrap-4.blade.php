@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center my-4 font-sans w-full">
        <ul class="pagination flex items-center justify-center flex-wrap gap-1.5 m-0 p-0" style="display: flex !important; flex-direction: row !important; flex-wrap: wrap !important; list-style: none !important; margin: 0 !important; padding: 0 !important; gap: 6px !important; align-items: center !important; justify-content: center !important;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" style="display: inline-block !important; list-style: none !important;" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link inline-flex items-center justify-center px-3 h-9 rounded-xl border border-slate-200 bg-slate-50 text-slate-300 text-xs font-semibold cursor-not-allowed select-none" style="display: inline-flex !important; align-items: center !important; justify-content: center !important; min-width: 36px !important; height: 36px !important; border-radius: 10px !important; border: 1px solid #E2E8F0 !important; background-color: #F8FAFC !important; color: #94A3B8 !important; text-decoration: none !important;">
                        <i class="fas fa-chevron-left text-[10px]"></i>
                    </span>
                </li>
            @else
                <li class="page-item" style="display: inline-block !important; list-style: none !important;">
                    <a class="page-link inline-flex items-center justify-center px-3 h-9 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-blue-50 hover:text-blue-700 hover:border-blue-300 transition text-xs font-semibold shadow-xs" style="display: inline-flex !important; align-items: center !important; justify-content: center !important; min-width: 36px !important; height: 36px !important; border-radius: 10px !important; border: 1px solid #E2E8F0 !important; background-color: #FFFFFF !important; color: #334155 !important; text-decoration: none !important;" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="fas fa-chevron-left text-[10px]"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" style="display: inline-block !important; list-style: none !important;" aria-disabled="true">
                        <span class="page-link inline-flex items-center justify-center px-2 h-9 text-slate-400 text-xs font-bold" style="display: inline-flex !important; align-items: center !important; justify-content: center !important; min-width: 28px !important; height: 36px !important; color: #94A3B8 !important; text-decoration: none !important;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" style="display: inline-block !important; list-style: none !important;" aria-current="page">
                                <span class="page-link inline-flex items-center justify-center px-3.5 h-9 rounded-xl border border-blue-600 bg-blue-600 text-white font-black text-xs shadow-sm" style="display: inline-flex !important; align-items: center !important; justify-content: center !important; min-width: 36px !important; height: 36px !important; border-radius: 10px !important; border: 1px solid #1A56DB !important; background-color: #1A56DB !important; color: #FFFFFF !important; text-decoration: none !important; font-weight: 800 !important;">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item" style="display: inline-block !important; list-style: none !important;">
                                <a class="page-link inline-flex items-center justify-center px-3.5 h-9 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-blue-50 hover:text-blue-700 hover:border-blue-300 transition text-xs font-semibold shadow-xs" style="display: inline-flex !important; align-items: center !important; justify-content: center !important; min-width: 36px !important; height: 36px !important; border-radius: 10px !important; border: 1px solid #E2E8F0 !important; background-color: #FFFFFF !important; color: #334155 !important; text-decoration: none !important;" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item" style="display: inline-block !important; list-style: none !important;">
                    <a class="page-link inline-flex items-center justify-center px-3 h-9 rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-blue-50 hover:text-blue-700 hover:border-blue-300 transition text-xs font-semibold shadow-xs" style="display: inline-flex !important; align-items: center !important; justify-content: center !important; min-width: 36px !important; height: 36px !important; border-radius: 10px !important; border: 1px solid #E2E8F0 !important; background-color: #FFFFFF !important; color: #334155 !important; text-decoration: none !important;" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" style="display: inline-block !important; list-style: none !important;" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link inline-flex items-center justify-center px-3 h-9 rounded-xl border border-slate-200 bg-slate-50 text-slate-300 text-xs font-semibold cursor-not-allowed select-none" style="display: inline-flex !important; align-items: center !important; justify-content: center !important; min-width: 36px !important; height: 36px !important; border-radius: 10px !important; border: 1px solid #E2E8F0 !important; background-color: #F8FAFC !important; color: #94A3B8 !important; text-decoration: none !important;">
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
