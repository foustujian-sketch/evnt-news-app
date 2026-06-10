@extends('layouts.admin')

@section('title', ' | NEWS API SYNC')

@section('content')
<header class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6 border-b-[4px] border-on-background pb-8">
    <div>
        <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg uppercase flex items-center gap-4">
            [ NEWS_API_SYNC ]
            <span class="material-symbols-outlined text-4xl md:text-5xl" style="font-variation-settings: 'FILL' 1;">sync</span>
        </h2>
        <p class="font-label-mono text-label-mono text-tertiary mt-2">API_AGGREGATION // LATEST_FETCHED_DATA</p>
    </div>
    <div class="flex gap-4 w-full md:w-auto items-center">
        <div class="hidden md:flex flex-col text-right mr-4">
            <span class="font-label-mono text-label-mono text-tertiary">NEXT_AUTO_FETCH</span>
            <span class="font-headline-sm text-headline-sm text-primary terminal-cursor" id="next-fetch-countdown">--m --s</span>
        </div>
        <form action="{{ route('admin.api-sync.fetch') }}" method="POST" class="flex-1 md:flex-none" onsubmit="document.getElementById('fetch-btn').innerHTML='<span class=\'material-symbols-outlined animate-spin\'>sync</span> SYNCING...';">
            @csrf
            <button id="fetch-btn" type="submit" class="brutal-btn bg-primary-container text-on-primary-container font-label-bold text-label-bold uppercase border-[4px] border-on-background px-6 py-3 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all flex items-center justify-center gap-2 w-full">
                <span class="material-symbols-outlined">refresh</span>
                FORCE_FETCH_NOW
            </button>
        </form>
    </div>
</header>

<script>
    function updateFetchCountdown() {
        const now = new Date();
        const nextHour = new Date(now);
        nextHour.setHours(now.getHours() + 1, 0, 0, 0);
        const diff = nextHour - now;
        
        const m = Math.floor(diff / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        const countdownEl = document.getElementById('next-fetch-countdown');
        if (countdownEl) {
            countdownEl.innerText = `${m.toString().padStart(2, '0')}m ${s.toString().padStart(2, '0')}s`;
        }
    }
    setInterval(updateFetchCountdown, 1000);
    updateFetchCountdown();
</script>

@if(session('success'))
<div class="bg-primary-container text-on-primary-container border-[4px] border-on-background p-4 mb-8 font-label-mono text-label-mono shadow-block-green flex items-center gap-4">
    <span class="material-symbols-outlined">check_circle</span>
    {{ session('success') }}
</div>
@endif

<div class="bg-surface border-[4px] border-on-background shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full table-fixed text-left border-collapse">
            <thead class="bg-surface-container-highest border-b-[4px] border-on-background">
                <tr>
                    <th class="p-4 w-16 font-label-mono text-label-mono uppercase border-r-[4px] border-on-background">ID</th>
                    <th class="p-4 w-24 font-label-mono text-label-mono uppercase border-r-[4px] border-on-background">IMAGE</th>
                    <th class="p-4 w-auto font-label-mono text-label-mono uppercase border-r-[4px] border-on-background">TITLE</th>
                    <th class="p-4 w-1/4 font-label-mono text-label-mono uppercase border-r-[4px] border-on-background">AUTHOR</th>
                    <th class="p-4 w-32 font-label-mono text-label-mono uppercase border-r-[4px] border-on-background">PUBLISHED</th>
                    <th class="p-4 w-24 font-label-mono text-label-mono uppercase">URL</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr class="border-b-[4px] border-on-background hover:bg-surface-container-lowest transition-colors">
                        <td class="p-4 font-body-md border-r-[4px] border-on-background">#{{ $event->id }}</td>
                        <td class="p-4 font-body-md border-r-[4px] border-on-background">
                            @if($event->image_path)
                                <img src="{{ $event->image_path }}" alt="Thumbnail" class="w-16 h-16 object-cover border-2 border-on-background">
                            @else
                                <div class="w-16 h-16 bg-primary-container border-2 border-on-background flex items-center justify-center text-xs font-label-bold">
                                    [NO_IMG]
                                </div>
                            @endif
                        </td>
                        <td class="p-4 font-label-bold border-r-[4px] border-on-background max-w-xs truncate">{{ $event->title }}</td>
                        <td class="p-4 font-body-md border-r-[4px] border-on-background truncate max-w-xs">{{ $event->author_name }}</td>
                        <td class="p-4 font-label-mono text-sm border-r-[4px] border-on-background">{{ $event->publish_date->format('Y-m-d') }}</td>
                        <td class="p-4 font-body-md">
                            <a href="{{ $event->source_url }}" target="_blank" class="text-primary hover:underline decoration-2">Link ↗</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center font-label-mono text-tertiary uppercase">NO_EVENTS_FOUND_IN_DATABASE</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $events->links() }}
</div>
@endsection
