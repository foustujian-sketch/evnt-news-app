@extends('layouts.admin')

@section('title', ' | ' . $title)

@section('content')
<header class="flex flex-col mb-12 gap-6 border-b-[4px] border-on-background pb-8">
    <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg uppercase terminal-cursor">{{ $title }}</h2>
    <p class="font-label-mono text-label-mono text-tertiary mt-2">SYS_TIME: <span id="sys-time"></span> | STATUS: STANDBY</p>
</header>

<section class="flex flex-col items-center justify-center min-h-[40vh] text-center gap-6 border-[4px] border-on-background shadow-block-black bg-surface p-12">
    <span class="material-symbols-outlined text-6xl text-primary-container" style="font-variation-settings: 'FILL' 1;">construction</span>
    <h3 class="font-headline-md text-headline-md uppercase">MODULE_PENDING</h3>
    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
        This section is currently under construction. It will be fully operational once the backend logic (Controllers & Database) is integrated.
    </p>
    <a href="/admin/dashboard" class="mt-6 bg-primary-container text-on-background border-[4px] border-on-background px-8 py-4 font-label-bold text-label-bold uppercase shadow-block-black interactive-element flex items-center gap-2">
        <span class="material-symbols-outlined">arrow_back</span>
        [ RETURN_TO_DASHBOARD ]
    </a>
</section>

<script>
    function updateTime() {
        const now = new Date();
        const timeString = now.toISOString().replace('T', ' ').substring(0, 19);
        const sysTimeElement = document.getElementById('sys-time');
        if (sysTimeElement) {
            sysTimeElement.textContent = timeString;
        }
    }
    updateTime();
    setInterval(updateTime, 1000);
</script>
@endsection
