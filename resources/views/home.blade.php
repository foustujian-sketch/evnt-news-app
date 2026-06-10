@extends('layouts.app')

@section('title', ' | FEED')

@section('content')
<!-- Hero Section -->
<section class="w-screen relative left-1/2 -translate-x-1/2 border-b-[4px] border-on-background overflow-hidden bg-surface-container-lowest px-6 md:px-12 lg:px-24 mb-16 border-t-[4px] -mt-8 md:-mt-12">
    <!-- Abstract Grid Background Pattern -->
    <div class="absolute inset-0 opacity-10 pointer-events-none animate-grid-left" style="background-image: linear-gradient(#1a1c1c 2px, transparent 2px), linear-gradient(90deg, #1a1c1c 2px, transparent 2px); background-size: 40px 40px;"></div>
    <div class="py-6 md:py-8 relative z-10 flex flex-col justify-center items-start w-full max-w-container-max mx-auto">
        <div class="inline-block bg-on-background text-primary-container font-label-mono text-label-mono px-3 py-1 mb-6 border-[2px] border-primary-container self-start uppercase">
            INIT_SEQUENCE: OK
        </div>
        <h1 class="font-headline-xl text-[64px] md:text-[96px] lg:text-[120px] text-on-background uppercase max-w-6xl leading-[0.85] tracking-tighter">
            SYSTEM: BOOTING...<br>
            <span class="text-transparent bg-clip-text" style="background-color: #39ff14; color: black; padding: 0 12px; -webkit-text-stroke: 4px black;">FIND YOUR NEXT</span><br>
            TECH EVENT.
        </h1>
        <div class="mt-12 flex flex-col md:flex-row flex-wrap gap-4 md:gap-6 w-full md:w-auto">
            <a href="#feed" class="bg-primary-container text-on-background border-[4px] border-on-background px-8 md:px-12 py-4 md:py-6 font-label-bold text-[18px] md:text-[20px] uppercase shadow-[8px_8px_0px_0px_#1a1c1c] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all text-center w-full md:w-auto">
                EXPLORE_EVENTS
            </a>
            <button type="button" onclick="toggleFilterSidebar()" class="bg-surface-container-lowest text-on-background border-[4px] border-on-background px-8 md:px-12 py-4 md:py-6 font-label-bold text-[18px] md:text-[20px] uppercase shadow-[8px_8px_0px_0px_#1a1c1c] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all flex justify-center items-center gap-3 w-full md:w-auto">
                <span class="material-symbols-outlined text-[24px] md:text-[28px]">filter_list</span>
                FILTER
            </button>
        </div>
    </div>
</section>

<!-- Main Feed Layout (Dense Grid) -->
<section id="feed" class="bg-surface-container-low flex-1 scroll-mt-24">
    <div class="flex items-center justify-between mb-8 border-b-[4px] border-on-background pb-4">
        <h2 class="font-headline-md text-headline-sm md:text-headline-md uppercase flex items-center gap-3">
            <span class="w-4 h-4 bg-primary-container border-[2px] border-on-background inline-block animate-pulse"></span>
            LATEST_DROPS
        </h2>
        <div class="font-label-mono text-label-mono uppercase text-on-tertiary-container">
            SORT: CHRONOLOGICAL
        </div>
    </div>

    <!-- Standard Grid Layout for Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8 auto-rows-[minmax(300px,auto)]">
        @forelse($events as $event)
            <article class="bg-surface-container-lowest border-[4px] border-on-background shadow-[8px_8px_0px_0px_#1a1c1c] flex flex-col group relative overflow-hidden transition-transform duration-200 hover:-translate-y-1 mr-2 mb-2 md:mr-3 md:mb-3">
                <div class="h-48 border-b-[4px] border-on-background relative bg-surface-variant overflow-hidden">
                    @if($event->image_path)
                        <img alt="{{ $event->title }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500" src="{{ $event->image_path }}">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center bg-primary-container p-4 text-center group-hover:bg-primary transition-colors duration-500">
                            <span class="material-symbols-outlined text-4xl mb-2">code_blocks</span>
                            <span class="font-label-bold uppercase border-[2px] border-on-background px-2 py-1 bg-surface-container-lowest shadow-[2px_2px_0px_0px_#000]">NO_IMAGE_DATA</span>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-secondary-container text-on-background font-label-bold text-label-bold px-3 py-1 border-[2px] border-on-background uppercase shadow-[2px_2px_0px_0px_#000]">
                        {{ $event->publish_date->format('M d') }}
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-surface-container-high border-[2px] border-on-background px-2 py-1 font-label-mono text-label-mono uppercase text-[10px]">#{{ strtoupper(explode(' ', $event->title)[0] ?? 'TECH') }}</span>
                    </div>
                    <h3 class="font-headline-sm text-[20px] uppercase mb-2 group-hover:text-primary transition-colors line-clamp-2 leading-tight">
                        {{ $event->title }}
                    </h3>
                    <p class="font-label-mono text-[11px] text-on-tertiary-container mb-6 flex-1 line-clamp-2">
                        {{ $event->content }}
                    </p>
                    <a class="bg-primary-container text-on-background border-[4px] border-on-background px-4 py-2 font-label-bold text-label-bold uppercase shadow-[4px_4px_0px_0px_#1a1c1c] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all text-center w-full mt-auto block" href="{{ route('events.show', $event->slug) }}">
                        READ_MORE
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-24 border-[4px] border-on-background bg-surface-container-highest shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
                <span class="material-symbols-outlined text-6xl text-tertiary mb-4">database_off</span>
                <h2 class="font-headline-md uppercase mb-2">NO_EVENTS_FOUND</h2>
                <p class="font-label-mono text-tertiary">NO_RECORDS_FOUND // AWAITING_SYSTEM_SYNC</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12 flex justify-center pb-12 w-full">
        {{ $events->fragment('feed')->links('components.pagination') }}
    </div>

    @include('components.filter-sidebar')
</section>
@endsection

<script>
    // Smooth scroll to feed on page load if hash is present (e.g., from pagination)
    document.addEventListener("DOMContentLoaded", function() {
        if (window.location.hash === '#feed') {
            // Instantly snap to top before browser tries to jump to anchor
            window.scrollTo(0, 0);
            // Wait a microsecond for layout to stabilize, then smoothly slide down
            setTimeout(() => {
                const feed = document.getElementById('feed');
                if (feed) {
                    feed.scrollIntoView({ behavior: 'smooth' });
                }
            }, 100);
        }
    });
</script>
