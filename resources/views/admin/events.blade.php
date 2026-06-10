@extends('layouts.admin')

@section('title', ' | MANAGE_EVENTS')

@section('content')
<!-- Header Area -->
<header class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6 border-b-[4px] border-on-background pb-8">
    <div>
        <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg uppercase terminal-cursor">MANAGE_EVENTS // OVERVIEW</h2>
        <p class="font-label-mono text-label-mono text-tertiary mt-2">SYS_TIME: <span id="sys-time" class="">2026-06-09 22:21:03</span> | STATUS: OK</p>
    </div>
</header>

<!-- Database Table Section -->
<section class="mb-12">
    <div class="mb-8 relative group">
        <form action="{{ route('admin.events.index') }}" method="GET" class="flex items-center bg-white border-[4px] border-on-background shadow-block-black transition-all duration-100 focus-within:translate-x-1 focus-within:translate-y-1 focus-within:shadow-none">
            <div class="bg-on-background px-4 py-4 flex items-center justify-center">
                <span class="font-label-mono text-primary-container font-bold whitespace-nowrap">QUERY &gt;</span>
            </div>
            <input name="q" value="{{ request('q') }}" type="text" placeholder="SEARCH_LOGS_BY_ID_OR_TITLE..." class="flex-1 p-4 bg-transparent font-label-mono text-body-md text-on-background placeholder:text-tertiary focus:outline-none" aria-label="Search logs">
            <button type="submit" class="px-4 hover:text-primary transition-colors cursor-pointer flex items-center justify-center">
                <span class="material-symbols-outlined text-on-background">search</span>
            </button>
        </form>
    </div>
    
    <h3 class="font-headline-md text-headline-md uppercase mb-6 terminal-cursor">EVENTS/news</h3>
    <div class="overflow-x-auto border-[4px] border-on-background shadow-block-black bg-surface">
        <table class="w-full text-left font-body-md whitespace-nowrap">
            <thead class="bg-surface-container-highest border-b-[4px] border-on-background font-label-bold text-label-bold uppercase">
                <tr>
                    <th class="p-4 border-r-[4px] border-on-background">ID</th>
                    <th class="p-4 border-r-[4px] border-on-background">DATA_SNIPPET</th>
                    <th class="p-4 border-r-[4px] border-on-background">AUTHOR/SOURCE</th>
                    <th class="p-4 border-r-[4px] border-on-background">DATE</th>
                    <th class="p-4">ACTIONS</th>
                </tr>
            </thead>
            <tbody class="font-label-mono text-label-mono divide-y-[4px] divide-on-background">
                @forelse ($events as $event)
                <!-- Row -->
                <tr class="hover:bg-surface-container transition-colors">
                    <td class="p-4 border-r-[4px] border-on-background font-bold text-primary">#EVT-{{ $event->id }}</td>
                    <td class="p-4 border-r-[4px] border-on-background"><code class="bg-surface-container-highest px-2 py-1 border-[4px] border-on-background">{{ Str::limit($event->title, 30) }}</code></td>
                    <td class="p-4 border-r-[4px] border-on-background">{{ $event->author_name ?? 'SYS_ADMIN' }}</td>
                    <td class="p-4 border-r-[4px] border-on-background">{{ $event->publish_date ? $event->publish_date->format('Y-m-d H:i') : '' }}</td>
                    <td class="p-4 flex gap-2">
                        <a href="{{ route('admin.events.edit', $event->id) }}" aria-label="Edit" class="w-10 h-10 bg-secondary-fixed border-[4px] border-on-background shadow-[4px_4px_0px_0px_#1a1c1c] hover:shadow-[2px_2px_0px_0px_#1a1c1c] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none transition-all flex items-center justify-center text-on-secondary-fixed">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </a>
                        <button type="button" onclick="confirmDelete('{{ route('admin.events.destroy', $event->id) }}')" aria-label="Delete" class="w-10 h-10 bg-error border-[4px] border-on-background shadow-[4px_4px_0px_0px_#1a1c1c] hover:shadow-[2px_2px_0px_0px_#1a1c1c] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none transition-all flex items-center justify-center text-on-error">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center">NO_RECORDS_FOUND</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $events->links() }}
    </div>
</section>

<hr class="border-t-[4px] border-on-background my-12">

<h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg uppercase terminal-cursor mb-8">SYSTEM_INPUT // DATA_ENTRY</h2>

@if ($errors->any())
    <div class="bg-error-container text-on-error-container border-[4px] border-error p-4 mb-8 font-label-mono text-label-mono">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="bg-primary-container text-on-primary-container border-[4px] border-on-background p-4 mb-8 font-label-mono text-label-mono shadow-block-green">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('admin.events.store') }}" method="POST">
    @csrf
    <!-- FORM GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter mb-12">
        <!-- LEFT COLUMN: 70% -->
        <div class="lg:col-span-8 flex flex-col gap-8">
            <!-- EVENT TITLE -->
            <div class="flex flex-col gap-2">
                <label class="font-label-bold text-label-bold uppercase text-on-background bg-secondary-fixed px-2 py-1 w-fit border-[4px] border-on-background">EVENT_TITLE</label>
                <input name="title" value="{{ old('title') }}" class="w-full border-[4px] border-on-background p-4 font-headline-md text-headline-md text-on-background bg-surface-container-lowest focus:outline-none focus:shadow-[8px_8px_0px_0px_#39ff14] focus:-translate-y-1 focus:-translate-x-1 transition-all" placeholder="[ ENTER_TITLE_HERE ]" type="text" required>
            </div>
            <!-- IMAGE SOURCE -->
            <div class="flex flex-col gap-2">
                <label class="font-label-bold text-label-bold uppercase text-on-background bg-secondary-fixed px-2 py-1 w-fit border-[4px] border-on-background">IMAGE_SOURCE_URL</label>
                <input name="image_path" value="{{ old('image_path') }}" class="w-full border-[4px] border-on-background p-4 font-body-md text-body-md text-on-background bg-surface-container-lowest focus:outline-none focus:shadow-[8px_8px_0px_0px_#39ff14] focus:-translate-y-1 focus:-translate-x-1 transition-all" placeholder="https://cdn.devcore.sys/assets/..." type="url">
            </div>
            <!-- CONTENT AREA -->
            <div class="flex flex-col gap-2 flex-1">
                <label class="font-label-bold text-label-bold uppercase text-on-background bg-secondary-fixed px-2 py-1 w-fit border-[4px] border-on-background flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">terminal</span>
                    EVENT_CONTENT // RAW_DATA
                </label>
                <textarea name="content" class="w-full flex-1 min-h-[400px] border-[4px] border-on-background p-6 font-label-mono text-body-md text-on-background bg-surface-variant focus:outline-none focus:shadow-[8px_8px_0px_0px_#39ff14] focus:-translate-y-1 focus:-translate-x-1 transition-all resize-y leading-relaxed" placeholder="&gt; INITIALIZING EDITOR...&#10;&gt; WAITING FOR INPUT..." required>{{ old('content') }}</textarea>
            </div>
        </div>
        
        <!-- RIGHT COLUMN: 30% -->
        <div class="lg:col-span-4 flex flex-col gap-8">
            <!-- METADATA PANEL -->
            <div class="bg-surface-container-lowest border-[4px] border-on-background p-6 shadow-block-yellow h-full flex flex-col gap-8">
                <h2 class="font-headline-sm text-headline-sm text-on-background uppercase border-b-4 border-on-background pb-2 flex justify-between items-center">
                    METADATA
                    <span class="material-symbols-outlined">settings_ethernet</span>
                </h2>
                <!-- PUBLISH DATE -->
                <div class="flex flex-col gap-2">
                    <label class="font-label-bold text-label-bold uppercase text-on-background flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">calendar_month</span>
                        PUBLISH_DATE
                    </label>
                    <input name="publish_date" value="{{ old('publish_date') }}" class="w-full border-[4px] border-on-background p-3 font-label-mono text-body-md text-on-background bg-surface-container-lowest focus:outline-none focus:shadow-[8px_8px_0px_0px_#39ff14] focus:-translate-y-1 focus:-translate-x-1 transition-all" type="date" required>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER ACTIONS -->
    <div class="flex flex-col sm:flex-row gap-6 mt-12 pt-8 border-t-4 border-on-background">
        <button type="submit" class="flex-[2] bg-primary-container border-[4px] border-on-background p-6 font-headline-sm text-headline-sm uppercase text-on-background shadow-block-green hover:bg-primary-fixed-dim interactive-element transition-colors flex items-center justify-center gap-4">
            <span class="material-symbols-outlined">save</span>
            [ COMMIT_RECORD ]
        </button>
    </div>
</form>

<script>
    // Simple script to update system time
    function updateTime() {
        const now = new Date();
        const timeString = now.toISOString().replace('T', ' ').substring(0, 19);
        const timeElement = document.getElementById('sys-time');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }
    updateTime();
    setInterval(updateTime, 1000);
</script>
@endsection
