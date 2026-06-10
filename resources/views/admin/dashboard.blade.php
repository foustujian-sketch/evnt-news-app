@extends('layouts.admin')

@section('title', ' | OVERVIEW')

@section('content')
<!-- Header Area -->
<header class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6 border-b-[4px] border-on-background pb-8">
    <div>
        <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg uppercase terminal-cursor">OVERVIEW_</h2>
        <p class="font-label-mono text-label-mono text-tertiary mt-2">SYS_TIME: <span class="" id="sys-time"></span> | STATUS: OK</p>
    </div>
</header>

<!-- Quick Stats (Bento Grid) -->
<section class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-12">
    <!-- Stat Box 1 -->
    <div class="bg-surface border-[4px] border-on-background p-6 shadow-[8px_8px_0px_0px_#1a1c1c] interactive-element flex flex-col justify-between min-h-[160px]">
        <h3 class="font-label-bold text-label-bold uppercase text-tertiary">TOTAL_EVENTS</h3>
        <p class="font-headline-xl text-headline-xl text-on-background">{{ number_format($totalEvents) }}</p>
    </div>
    <!-- Stat Box 2 (Yellow) -->
    <div class="bg-secondary-fixed border-[4px] border-on-background p-6 shadow-[8px_8px_0px_0px_#1a1c1c] interactive-element flex flex-col justify-between min-h-[160px]">
        <h3 class="font-label-bold text-label-bold uppercase text-on-secondary-fixed">ACTIVE_USERS</h3>
        <p class="font-headline-xl text-headline-xl text-on-secondary-fixed">{{ number_format($activeUsers) }}</p>
    </div>
    <!-- Stat Box 3 (Black) -->
    <a href="{{ route('admin.api-sync') }}" class="bg-on-background border-[4px] border-on-background p-6 shadow-[8px_8px_0px_0px_#39ff14] interactive-element flex flex-col justify-between min-h-[160px] group">
        <h3 class="font-label-bold text-label-bold uppercase text-primary-container">API_SYNC_STATUS</h3>
        <div class="flex items-center gap-2 text-primary-container mt-auto group-hover:text-primary-fixed-dim transition-colors">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">sync</span>
            <p class="font-headline-md text-headline-md">READY</p>
        </div>
    </a>
</section>

<!-- Database Table Section -->
<section class="mb-12">
    <h3 class="font-headline-md text-headline-md uppercase mb-6 terminal-cursor">RECENT_LOGS</h3>
    <div class="overflow-x-auto border-[4px] border-on-background shadow-[8px_8px_0px_0px_#1a1c1c] bg-surface mb-6">
        <table class="w-full text-left font-body-md whitespace-nowrap">
            <thead class="bg-surface-container-highest border-b-[4px] border-on-background font-label-bold text-label-bold uppercase">
                <tr>
                    <th class="p-4 border-r-[4px] border-on-background">ID</th>
                    <th class="p-4 border-r-[4px] border-on-background">DATA_SNIPPET</th>
                    <th class="p-4 border-r-[4px] border-on-background">AUTHOR/SOURCE</th>
                    <th class="p-4">DATE</th>
                </tr>
            </thead>
            <tbody class="font-label-mono text-label-mono divide-y-[4px] divide-on-background">
                @forelse ($recentLogs as $log)
                <tr class="hover:bg-surface-container transition-colors">
                    <td class="p-4 border-r-[4px] border-on-background font-bold text-primary">{{ $log->id }}</td>
                    <td class="p-4 border-r-[4px] border-on-background">
                        <code class="bg-surface-container-highest px-2 py-1 border-[4px] border-on-background">{{ $log->snippet }}</code>
                    </td>
                    <td class="p-4 border-r-[4px] border-on-background">{{ $log->author }}</td>
                    <td class="p-4">{{ $log->date->format('Y-m-d H:i:s') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center font-label-mono text-label-mono border-border-width border-on-background">NO_LOGS_FOUND_IN_DATABASE</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<script>
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
