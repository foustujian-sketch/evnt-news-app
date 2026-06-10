@extends('layouts.admin')

@section('title', ' | USER_DATABASE')

@section('content')
<!-- Header -->
<header class="mb-12 border-b-4 border-on-background pb-6">
    <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg uppercase text-on-background mb-2">USER_DATABASE // ACCOUNTS</h1>
    <p class="font-body-lg text-body-lg text-tertiary">&gt;_ SYSTEM_READY: Awaiting admin queries.</p>
</header>

<!-- Search and Filter Bar -->
<section class="flex flex-col md:flex-row gap-6 mb-12">
    <form action="{{ route('admin.users.index') }}" method="GET" class="flex-grow relative bg-surface border-4 border-on-background shadow-[8px_8px_0px_0px_#39ff14] focus-within:translate-x-1 focus-within:translate-y-1 focus-within:shadow-none transition-all duration-100 flex items-center">
        <button type="submit" class="pl-4 pr-2 flex items-center hover:text-primary-container focus:outline-none transition-colors">
            <span class="material-symbols-outlined text-primary">search</span>
        </button>
        <input name="q" value="{{ request('q') }}" class="w-full h-14 pr-4 bg-transparent font-label-bold text-label-bold placeholder-tertiary focus:outline-none border-none ring-0 focus:ring-0" placeholder="SEARCH_USER_BY_ID_OR_EMAIL..." type="text">
    </form>
    <div class="md:w-64 relative bg-surface border-4 border-on-background shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] focus-within:translate-x-1 focus-within:translate-y-1 focus-within:shadow-none transition-all duration-100 flex items-center">
        <form action="{{ route('admin.users.index') }}" method="GET" class="w-full" id="role-filter-form">
            @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
            <select name="role" onchange="document.getElementById('role-filter-form').submit()" class="w-full h-14 pl-4 pr-10 bg-transparent font-label-bold text-label-bold focus:outline-none appearance-none cursor-pointer border-none ring-0 focus:ring-0">
                <option value="">ROLE: ALL</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>ROLE: ROOT_ADMIN</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>ROLE: STANDARD_USER</option>
            </select>
        </form>
        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
            <span class="material-symbols-outlined" data-icon="arrow_drop_down">arrow_drop_down</span>
        </div>
    </div>
</section>

<!-- Stats Row -->
<section class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
    <div class="bg-surface border-4 border-on-background p-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-between h-48 relative overflow-hidden group hover:-translate-y-1 transition-transform">
        <div class="absolute top-0 right-0 bg-primary-container border-l-4 border-b-4 border-on-background px-4 py-2 font-label-mono text-label-mono uppercase text-on-primary-container z-10">
            STAT_01
        </div>
        <div class="font-label-bold text-label-bold text-tertiary uppercase relative z-10">TOTAL_REGISTERED_USERS</div>
        <div class="font-headline-xl text-headline-xl text-on-background relative z-10 transition-transform group-hover:translate-x-2">{{ number_format($totalUsers) }}</div>
        <!-- Decorative background elements -->
        <div class="absolute -bottom-8 -right-8 w-32 h-32 border-4 border-on-background opacity-10 rounded-full"></div>
    </div>
    <div class="bg-surface border-4 border-on-background p-8 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] flex flex-col justify-between h-48 relative overflow-hidden group hover:-translate-y-1 transition-transform">
        <div class="absolute top-0 right-0 bg-secondary-container border-l-4 border-b-4 border-on-background px-4 py-2 font-label-mono text-label-mono uppercase text-on-secondary-container z-10">
            STAT_02
        </div>
        <div class="font-label-bold text-label-bold text-tertiary uppercase relative z-10">ADMIN_ACCOUNTS</div>
        <div class="font-headline-xl text-headline-xl text-on-background relative z-10 transition-transform group-hover:translate-x-2">{{ number_format($totalAdmins) }}</div>
        <!-- Decorative background elements -->
        <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: radial-gradient(#000 2px, transparent 2px); background-size: 16px 16px;"></div>
    </div>
</section>

<!-- Data Table -->
<section class="overflow-x-auto w-full mb-12">
    <table class="w-full text-left border-collapse border-4 border-on-background min-w-[900px]">
        <thead>
            <tr class="bg-surface-container-high border-b-4 border-on-background font-label-bold text-label-bold uppercase">
                <th class="p-4 border-r-4 border-on-background">USER_ID</th>
                <th class="p-4 border-r-4 border-on-background">USERNAME / EMAIL</th>
                <th class="p-4 border-r-4 border-on-background">ROLE_LEVEL</th>
                <th class="p-4 border-r-4 border-on-background">CREATED_AT</th>
                <th class="p-4">ACTIONS</th>
            </tr>
        </thead>
        <tbody class="font-body-md text-body-md bg-surface">
            @forelse ($users as $user)
            <tr class="border-b-4 border-on-background hover:bg-surface-container-lowest transition-colors">
                <td class="p-4 border-r-4 border-on-background font-label-mono text-label-mono">#USR-{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</td>
                <td class="p-4 border-r-4 border-on-background">
                    <div class="font-bold uppercase">{{ $user->name }}</div>
                    <div class="text-tertiary text-sm mt-1">{{ $user->email }}</div>
                </td>
                <td class="p-4 border-r-4 border-on-background">
                    @if($user->role === 'admin')
                    <span class="inline-block px-3 py-1 bg-primary-container text-on-primary-container border-2 border-on-background font-label-mono text-label-mono uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        [ ROOT_ADMIN ]
                    </span>
                    @else
                    <span class="inline-block px-3 py-1 bg-surface-container text-on-surface border-2 border-on-background font-label-mono text-label-mono uppercase shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                        [ STANDARD_USER ]
                    </span>
                    @endif
                </td>
                <td class="p-4 border-r-4 border-on-background font-label-mono text-label-mono">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                <td class="p-4 flex gap-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="w-10 h-10 flex items-center justify-center bg-secondary-container text-on-secondary-container border-2 border-on-background shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none active:translate-x-2 active:translate-y-2 active:shadow-none transition-all" title="EDIT_ROLE">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                    </a>
                    <button type="button" onclick="confirmDelete('{{ route('admin.users.destroy', $user->id) }}')" class="w-10 h-10 flex items-center justify-center bg-error text-on-error border-2 border-on-background shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none active:translate-x-2 active:translate-y-2 active:shadow-none transition-all" title="BAN_USER">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-4 text-center font-label-mono text-label-mono py-12">NO_USERS_FOUND_IN_DATABASE</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</section>

<div class="mt-4">
    {{ $users->links() }}
</div>

@if (session('success'))
    <div class="bg-primary-container text-on-primary-container border-[4px] border-on-background p-4 mb-8 font-label-mono text-label-mono shadow-[8px_8px_0px_0px_#39ff14]">
        {{ session('success') }}
    </div>
@endif

@endsection
