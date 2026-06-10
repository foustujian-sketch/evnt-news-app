@extends('layouts.admin')

@section('title', ' | MODERATE_COMMENTS')

@section('content')
<!-- Header Section -->
<header class="mb-12 border-b-border-width border-on-background pb-6 flex flex-col md:flex-row md:justify-between md:items-end gap-6">
    <div>
        <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg uppercase tracking-tighter">
            MODERATE_COMMENTS <br class="hidden md:block"> <span class="text-tertiary">// SYS_COMMENTS</span>
        </h1>
    </div>
    <div class="flex gap-4">
        <div class="bg-surface-container-lowest border-border-width border-on-background shadow-[8px_8px_0px_0px_#1a1c1c] p-4 w-48 text-center flex flex-col justify-center">
            <p class="font-label-mono text-label-mono text-on-surface-variant uppercase mb-2">TOTAL_COMMENTS</p>
            <p class="font-headline-md text-headline-md">{{ number_format($totalComments) }}</p>
        </div>
        <div class="bg-secondary-container border-border-width border-on-background shadow-[8px_8px_0px_0px_#1a1c1c] p-4 w-48 text-center flex flex-col justify-center opacity-50" title="Flagging system offline">
            <p class="font-label-mono text-label-mono text-on-secondary-container uppercase mb-2 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-sm">flag</span> FLAGGED_SPAM
            </p>
            <p class="font-headline-md text-headline-md">0</p>
        </div>
    </div>
</header>

@if (session('success'))
    <div class="bg-primary-container text-on-primary-container border-4 border-on-background p-4 mb-8 font-label-mono text-label-mono shadow-[8px_8px_0px_0px_#39ff14]">
        {{ session('success') }}
    </div>
@endif

<!-- Search & Filter Controls -->
<section class="mb-8 flex flex-col md:flex-row gap-6 items-center">
    <form action="{{ route('admin.comments.index') }}" method="GET" class="flex-1 w-full relative">
        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
        <input name="q" value="{{ request('q') }}" class="w-full bg-surface-container-lowest border-border-width border-on-background p-4 pl-12 font-body-lg text-body-lg focus:outline-none focus:border-on-background focus:ring-0 shadow-[8px_8px_0px_0px_#1a1c1c] focus:translate-x-[4px] focus:translate-y-[4px] focus:shadow-[4px_4px_0px_0px_#1a1c1c] transition-all placeholder:text-on-surface-variant" placeholder="SEARCH_USER_OR_KEYWORD..." type="text">
        <button type="submit" class="hidden">Search</button>
    </form>
    <div class="flex border-border-width border-on-background shadow-[8px_8px_0px_0px_#1a1c1c] w-full md:w-auto">
        <button class="flex-1 md:flex-none px-6 py-4 bg-primary-container text-on-background font-label-bold text-label-bold border-r-border-width border-on-background uppercase active:translate-x-1 active:translate-y-1 active:shadow-none transition-all">
            STATUS: ALL
        </button>
        <button class="flex-1 md:flex-none px-6 py-4 bg-surface-container-lowest text-on-background font-label-bold text-label-bold uppercase hover:bg-surface-variant active:translate-x-1 active:translate-y-1 active:shadow-none transition-all opacity-50 cursor-not-allowed" title="Flagging system offline">
            FLAGGED
        </button>
    </div>
</section>

<!-- Data Table -->
<section class="bg-surface-container-lowest border-border-width border-on-background shadow-[8px_8px_0px_0px_#1a1c1c] overflow-x-auto mb-12">
    <table class="w-full text-left border-collapse min-w-[800px] border-border-width border-on-background font-body-md">
        <thead>
            <tr class="border-b-border-width border-on-background bg-surface-variant">
                <th class="p-4 font-label-bold text-label-bold uppercase border-r-border-width border-on-background w-24 border-border-width">LOG_ID</th>
                <th class="p-4 font-label-bold text-label-bold uppercase border-r-border-width border-on-background w-48 border-border-width">AUTHOR</th>
                <th class="p-4 font-label-bold text-label-bold uppercase border-r-border-width border-on-background border-border-width">COMMENT_PAYLOAD</th>
                <th class="p-4 font-label-bold text-label-bold uppercase border-r-border-width border-on-background w-32 border-border-width">EVENT_REF</th>
                <th class="p-4 font-label-bold text-label-bold uppercase text-center w-32 border-border-width border-on-background">ACTIONS</th>
            </tr>
        </thead>
        <tbody class="font-body-md text-body-md">
            @forelse ($comments as $comment)
            <tr class="border-b-border-width border-on-background hover:bg-surface-container transition-colors">
                <td class="p-4 border-r-border-width border-on-background font-label-mono text-label-mono border-border-width">#CMT-{{ str_pad($comment->id, 3, '0', STR_PAD_LEFT) }}</td>
                <td class="p-4 border-r-border-width border-on-background border-border-width">
                    <div class="flex items-center gap-4">
                        <img src="{{ $comment->user->avatar_url }}" class="w-10 h-10 border-2 border-on-background bg-surface-container-highest shrink-0" alt="Avatar">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 {{ $comment->user->role === 'admin' ? 'bg-primary-container' : 'bg-surface-dim' }} border-2 border-on-background"></div>
                            {{{ '@' . $comment->user->name }}}
                        </div>
                    </div>
                </td>
                <td class="p-4 border-r-border-width border-on-background font-label-mono text-label-mono break-words text-on-surface-variant border-border-width max-w-md">
                    "{{ Str::limit($comment->body, 150) }}"
                </td>
                <td class="p-4 border-r-border-width border-on-background font-label-mono text-label-mono border-border-width text-primary">
                    <a href="{{ route('events.show', $comment->eventNews->slug) }}" target="_blank" class="hover:underline">EVT-{{ $comment->eventNews->id }}</a>
                </td>
                <td class="p-4 text-center border-border-width border-on-background">
                    <button type="button" onclick="confirmDelete('{{ route('admin.comments.destroy', $comment->id) }}')" class="bg-error text-on-error border-2 border-on-background p-2 uppercase font-label-bold text-label-bold flex items-center justify-center gap-1 w-full shadow-[4px_4px_0px_0px_#1a1c1c] hover:bg-error-container hover:text-on-error-container hover:translate-x-1 hover:translate-y-1 hover:shadow-[2px_2px_0px_0px_#1a1c1c] transition-all active:translate-x-[4px] active:translate-y-[4px] active:shadow-none" title="NUKE COMMENT">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                        NUKE
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-8 text-center font-label-mono text-label-mono border-border-width border-on-background">NO_COMMENTS_FOUND_IN_DATABASE</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</section>

<div class="mt-4">
    {{ $comments->links() }}
</div>
@endsection
