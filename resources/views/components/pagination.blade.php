@if ($paginator->hasPages())
    @php
        $isAdmin = request()->is('admin*');
        $navGap = $isAdmin ? 'gap-2 md:gap-4 my-8' : 'gap-6 md:gap-8 my-16';
        
        $prevNextClass = $isAdmin
            ? 'shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] border-[2px] px-3 py-1 md:px-4 md:py-2 text-[10px] md:text-label-mono hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]'
            : 'shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] border-[4px] px-4 py-2 md:px-6 md:py-4 text-label-mono hover:shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]';
            
        $activeClass = $isAdmin
            ? 'shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] border-[2px] px-3 py-1 md:px-4 md:py-2 min-w-[50px] md:min-w-[70px]'
            : 'shadow-[10px_10px_0px_0px_rgba(0,0,0,1)] border-[4px] px-4 py-2 md:px-6 md:py-4 min-w-[90px] md:min-w-[120px]';
            
        $activeTextClass = $isAdmin ? 'text-headline-sm md:text-headline-md' : 'text-headline-md md:text-headline-lg';
        $activeLabelClass = $isAdmin ? 'text-[6px]' : 'text-[8px]';
        
        $standardClass = $isAdmin
            ? 'shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] border-[2px] px-3 py-1 md:px-4 md:py-2 min-w-[40px] md:min-w-[50px] text-[12px] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]'
            : 'shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] border-[4px] px-4 py-2 md:px-6 md:py-3 min-w-[60px] md:min-w-[80px] text-body-md md:text-body-lg hover:shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]';
    @endphp

    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-wrap md:flex-nowrap items-center justify-center {{ $navGap }} w-full">
        
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button disabled class="opacity-50 cursor-not-allowed bg-surface border-on-background font-label-mono text-on-surface flex items-center gap-1 md:gap-2 {{ str_replace('hover:shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]', '', str_replace('hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]', '', $prevNextClass)) }}">
                <span class="material-symbols-outlined text-[14px] md:text-[18px]">chevron_left</span>
                PREV
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="hover:-translate-y-1 hover:-translate-x-1 active:translate-x-1 active:translate-y-1 active:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all bg-surface border-on-background font-label-mono text-on-surface hover:bg-primary-container flex items-center gap-1 md:gap-2 {{ $prevNextClass }}">
                <span class="material-symbols-outlined text-[14px] md:text-[18px]">chevron_left</span>
                PREV
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="flex flex-wrap md:flex-nowrap gap-2 md:gap-3 items-center">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <div class="flex items-end justify-center pb-1 md:pb-2 px-1">
                        <span class="font-bold text-sm md:text-xl tracking-[2px] md:tracking-[4px]">{{ $element }}</span>
                    </div>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- Active Page (Centerpiece) --}}
                            <div class="relative group mx-1 md:mx-2">
                                <div class="bg-secondary-container border-on-background flex flex-col items-center justify-center transition-transform active:translate-x-1 active:translate-y-1 active:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] cursor-default {{ $activeClass }}">
                                    <div class="absolute top-1 left-1.5 font-label-mono text-[6px] md:text-[7px] text-on-secondary-container opacity-60">ID_{{ sprintf('%03d', $page) }}</div>
                                    <div class="flex items-center gap-2 mb-1 mt-1 md:mt-2">
                                        <span class="font-headline-lg text-on-background leading-none {{ $activeTextClass }}">{{ $page }}</span>
                                    </div>
                                    <div class="bg-on-background text-secondary-container px-2 py-0.5 font-label-mono tracking-tighter mt-1 {{ $activeLabelClass }}">
                                        // ACTIVE
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Standard Page Link --}}
                            <a href="{{ $url }}" class="hover:-translate-y-1 hover:-translate-x-1 active:translate-x-1 active:translate-y-1 active:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all bg-surface border-on-background flex items-center justify-center font-label-mono text-on-surface hover:bg-primary-container hover:text-on-primary-container {{ $standardClass }}">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="hover:-translate-y-1 hover:-translate-x-1 active:translate-x-1 active:translate-y-1 active:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] transition-all bg-surface border-on-background font-label-mono text-on-surface hover:bg-primary-container flex items-center gap-1 md:gap-2 {{ $prevNextClass }}">
                NEXT
                <span class="material-symbols-outlined text-[14px] md:text-[18px]">chevron_right</span>
            </a>
        @else
            <button disabled class="opacity-50 cursor-not-allowed bg-surface border-on-background font-label-mono text-on-surface flex items-center gap-1 md:gap-2 {{ str_replace('hover:shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]', '', str_replace('hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]', '', $prevNextClass)) }}">
                NEXT
                <span class="material-symbols-outlined text-[14px] md:text-[18px]">chevron_right</span>
            </button>
        @endif
    </nav>
@endif
