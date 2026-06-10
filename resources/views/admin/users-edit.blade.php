@extends('layouts.admin')

@section('title', ' | MODIFY_USER_CLEARANCE')

@section('content')
<!-- Background Grid Pattern -->
<div class="fixed inset-0 opacity-10 pointer-events-none z-0" style="background-image: radial-gradient(circle at 2px 2px, #1a1c1c 1px, transparent 0); background-size: 24px 24px;"></div>

<!-- Dossier Card Container -->
<div class="relative z-10 w-full max-w-4xl bg-surface-container-lowest border-border-width border-on-background shadow-[8px_8px_0px_0px_#1a1c1c] flex flex-col p-8 md:p-12 gap-10 mt-8 mx-auto">
    <!-- Header Section -->
    <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 border-b-border-width border-on-background pb-8">
        <div class="flex flex-col gap-4 w-full">
            <div class="flex justify-between items-center w-full">
                <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg uppercase text-on-background">&gt;_MODIFY_USER_CLEARANCE</h2>
                <a href="{{ route('admin.users.index') }}" class="font-label-bold uppercase text-on-background hover:bg-on-background hover:text-on-primary border-4 border-on-background px-4 py-2 transition-colors">
                    [ RETURN ]
                </a>
            </div>
            <div class="flex flex-wrap gap-4">
                <div class="bg-on-background text-on-primary font-label-bold text-label-bold px-4 py-2 uppercase tracking-widest">
                    TARGET_ID: USR-{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}
                </div>
                <div class="bg-primary-container text-on-primary-container border-border-width border-on-background font-label-bold text-label-bold px-4 py-2 uppercase tracking-widest shadow-[8px_8px_0px_0px_#1a1c1c]">
                    STATUS: ACTIVE
                </div>
            </div>
        </div>
    </header>

    @if ($errors->any())
        <div class="bg-error-container text-on-error-container border-4 border-error p-4 font-label-mono text-label-mono">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- Inputs Section -->
        <section class="flex flex-col gap-8 mb-12">
            <!-- Read-only Email -->
            <div class="flex flex-col gap-2 relative">
                <label class="font-label-bold text-label-bold text-on-surface-variant uppercase bg-surface-container-lowest px-2 left-4 mb-4 w-fit">REGISTERED_EMAIL</label>
                <input class="w-full bg-surface-variant border-border-width border-on-background p-4 font-body-lg text-body-lg text-on-surface-variant cursor-not-allowed focus:ring-0 focus:outline-none" readonly type="email" value="{{ $user->email }}"/>
            </div>
            
            <!-- Editable Username -->
            <div class="flex flex-col gap-2 relative">
                <label class="font-label-bold text-label-bold text-on-background uppercase bg-surface-container-lowest px-2 left-4 mb-4 w-fit">USERNAME</label>
                <input name="name" class="w-full bg-surface-container-lowest border-border-width border-on-background p-4 font-body-lg text-body-lg text-on-background focus:ring-0 focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#106e00] transition-all" type="text" value="{{ old('name', $user->name) }}" required />
            </div>
            
            <!-- Dropdown Role -->
            <div class="flex flex-col gap-2 relative">
                <label class="font-label-bold text-label-bold text-on-background uppercase bg-surface-container-lowest px-2 left-4 mb-4 w-fit">ACCESS_LEVEL / ROLE</label>
                <div class="relative">
                    <select name="role" class="appearance-none w-full bg-surface-container-lowest border-border-width border-on-background p-4 font-body-lg text-body-lg text-on-background font-bold focus:ring-0 focus:outline-none focus:border-secondary-fixed focus:shadow-[4px_4px_0px_0px_#f6e600] transition-all cursor-pointer">
                        <option value="admin" {{ (old('role', $user->role) === 'admin') ? 'selected' : '' }}>[ ROOT_ADMIN ]</option>
                        <option value="user" {{ (old('role', $user->role) === 'user') ? 'selected' : '' }}>[ STANDARD_USER ]</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-on-background">
                        <span class="material-symbols-outlined text-3xl font-black">arrow_drop_down</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bottom Action -->
        <footer class="mt-8 pt-8 border-t-border-width border-on-background">
            <button type="submit" class="w-full bg-secondary-fixed text-on-secondary-fixed border-border-width border-on-background font-headline-sm text-headline-sm uppercase py-6 px-8 shadow-[8px_8px_0px_0px_#1a1c1c] hover:shadow-[4px_4px_0px_0px_#1a1c1c] hover:translate-x-1 hover:translate-y-1 active:translate-x-2 active:translate-y-2 active:shadow-none transition-all flex justify-center items-center gap-4 group">
                <span class="">[ OVERRIDE_USER_DATA ]</span>
                <span class="material-symbols-outlined text-4xl group-hover:translate-x-2 transition-transform">keyboard_double_arrow_right</span>
            </button>
        </footer>
    </form>

</div>
@endsection
