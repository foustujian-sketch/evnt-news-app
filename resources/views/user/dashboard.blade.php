@extends('layouts.app')

@section('title', ' | USER_CONTROL_PANEL')

@section('content')
<div class="mb-6 border-b-border-width border-on-background pb-4 flex flex-col md:flex-row md:items-center justify-between gap-6 relative">
    <div class="relative">
        <!-- Decorative Terminal Block -->
        <div class="absolute -top-4 -left-4 w-12 h-12 bg-primary-container border-border-width border-on-background z-0 hidden md:block"></div>
        <h1 class="relative z-10 font-headline-xl text-headline-lg-mobile md:text-[64px] text-on-surface uppercase break-words leading-none">
            &gt;_USER_CONTROL_PANEL
        </h1>
    </div>
</div>

<!-- Hidden Logout Form -->
<form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
    @csrf
</form>

<!-- Single Column Layout -->
<div class="flex flex-col gap-8">
    
    <!-- IDENTITY & SECURITY -->
    <section class="bg-surface-container-lowest border-border-width border-on-background shadow-[8px_8px_0px_0px_#39ff14] p-6 relative w-full">
        <!-- Accent decorative bar -->
        <div class="absolute top-0 left-0 w-full h-2 bg-on-background"></div>
        
        <h2 class="font-headline-md text-headline-md uppercase mb-8 flex items-center gap-3">
            <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">fingerprint</span>
            IDENTITY &amp; SECURITY
        </h2>
        
        <form class="flex flex-col gap-6" method="POST" action="{{ route('dashboard.update') }}">
            @csrf
            
            @if(session('success'))
                <div class="bg-primary-container text-on-background px-4 py-2 font-label-mono text-label-mono uppercase border-[2px] border-on-background shadow-[4px_4px_0px_0px_#000]">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="bg-error text-on-error px-4 py-2 font-label-mono text-label-mono uppercase border-[2px] border-on-background shadow-[4px_4px_0px_0px_#000]">
                    @foreach($errors->all() as $error)
                        <div>SYS_ERR: {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="flex flex-col md:flex-row gap-6">
                <!-- Update Username -->
                <div class="flex flex-col gap-2 flex-1">
                    <label class="font-label-mono text-label-mono uppercase text-on-surface-variant flex items-center gap-2" for="username">
                        <span class="w-3 h-3 bg-on-background inline-block"></span>
                        UPDATE_USERNAME
                    </label>
                    <input name="name" class="brutal-input w-full bg-surface-container-lowest border-border-width border-on-background p-4 font-body-lg text-body-lg text-on-surface focus:ring-0 transition-shadow" id="username" type="text" value="{{ Auth::check() ? Auth::user()->name : 'DEV_HACKER_99' }}">
                </div>
                
                <!-- Update Access Key -->
                <div class="flex flex-col gap-2 flex-1">
                    <label class="font-label-mono text-label-mono uppercase text-on-surface-variant flex items-center gap-2" for="access-key">
                        <span class="w-3 h-3 bg-on-background inline-block"></span>
                        UPDATE_ACCESS_KEY
                    </label>
                    <input name="password" class="brutal-input w-full bg-surface-container-lowest border-border-width border-on-background p-4 font-body-lg text-body-lg text-on-surface focus:ring-0 transition-shadow" id="access-key" type="password" placeholder="********">
                </div>
            </div>
            
            <!-- Actions -->
            <div class="mt-4 flex flex-col md:flex-row gap-4">
                <button class="brutal-btn flex-1 bg-secondary-container border-border-width border-on-background shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] text-on-surface font-label-bold text-label-bold uppercase py-4 px-8 text-lg flex items-center justify-center gap-3 hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all" type="submit">
                    SAVE_CHANGES
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">save</span>
                </button>
                <button form="logout-form" class="brutal-btn flex-1 bg-error text-on-error border-border-width border-on-background shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] font-label-bold text-label-bold uppercase py-4 px-8 text-lg flex items-center justify-center gap-3 hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all" type="submit">
                    [ EXIT ]
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">logout</span>
                </button>
            </div>
        </form>
    </section>

    <!-- SAVED_DROPS // BOOKMARKS -->
    <section class="flex flex-col gap-6">
        <h2 class="font-headline-md text-headline-md uppercase flex items-center gap-3 border-b-border-width border-on-background pb-4">
            <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">bookmarks</span>
            SAVED_DROPS // BOOKMARKS
        </h2>
        
        <!-- Horizontal Scroll Container -->
        <style>
            .hide-scrollbar::-webkit-scrollbar { display: none; }
            .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>
        <div class="flex overflow-x-auto snap-x snap-mandatory gap-6 pb-6 pt-2 hide-scrollbar w-full">
            @forelse($savedEvents as $event)
                <div id="saved-event-{{ $event->id }}" class="min-w-[320px] max-w-[320px] snap-start bg-surface-container-lowest border-border-width border-on-background p-4 flex flex-col gap-4 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] relative overflow-hidden group hover:-translate-y-1 transition-all shrink-0">
                    <!-- Glitch accent top -->
                    <div class="absolute top-0 left-0 w-full h-1 bg-primary-container group-hover:bg-primary transition-colors"></div>
                    <div class="aspect-video w-full bg-surface-container-high border-border-width border-on-background relative overflow-hidden">
                        @if($event->image_path)
                            <img alt="{{ $event->title }}" class="w-full h-full object-cover filter grayscale contrast-125 group-hover:grayscale-0 transition-all duration-300" src="{{ $event->image_path }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-surface-variant font-label-mono text-tertiary">NO_IMAGE</div>
                        @endif
                        <div class="absolute top-2 left-2 bg-primary-container border-2 border-on-background px-2 py-1 font-label-mono text-label-mono text-on-surface uppercase shadow-[2px_2px_0px_0px_#000]">
                            {{ strtoupper(explode(' ', $event->title)[0] ?? 'EVENT') }}
                        </div>
                    </div>
                    <div class="flex-grow">
                        <a href="{{ route('events.show', $event->slug) }}" class="font-headline-sm text-headline-sm uppercase line-clamp-2 mb-2 hover:text-primary transition-colors">{{ $event->title }}</a>
                        <p class="font-body-md text-body-md text-on-surface-variant font-bold">DATE: {{ $event->publish_date->format('Y-m-d') }}</p>
                    </div>
                    <button onclick="removeSavedEvent({{ $event->id }})" class="brutal-btn mt-2 w-full bg-error text-on-error border-border-width border-on-background shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] font-label-bold text-label-bold uppercase py-3 flex items-center justify-center gap-2 hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all">
                        <span id="remove-text-{{ $event->id }}">[ REMOVE_RECORD ]</span>
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">delete</span>
                    </button>
                </div>
            @empty
                <div class="w-full py-16 text-center border-4 border-dashed border-on-surface-variant font-label-mono text-on-surface-variant flex flex-col items-center gap-4">
                    <span class="material-symbols-outlined text-6xl">bookmark_border</span>
                    NO_SAVED_DROPS_FOUND // BROWSE_FEED_TO_SAVE
                </div>
            @endforelse
        </div>
        
        <script>
            async function removeSavedEvent(eventId) {
                const card = document.getElementById('saved-event-' + eventId);
                const text = document.getElementById('remove-text-' + eventId);
                
                text.innerText = 'PROCESSING...';
                
                try {
                    const response = await fetch(`/events/${eventId}/save`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    });
                    
                    if (response.ok) {
                        const data = await response.json();
                        if (!data.is_saved) {
                            card.style.transform = 'scale(0.9)';
                            card.style.opacity = '0';
                            setTimeout(() => card.remove(), 300);
                        }
                    } else {
                        text.innerText = '[ REMOVE_RECORD ]';
                        alert('Error removing record.');
                    }
                } catch(err) {
                    console.error(err);
                    text.innerText = '[ REMOVE_RECORD ]';
                    alert('Network error.');
                }
            }
        </script>
    </section>
</div>
@endsection
