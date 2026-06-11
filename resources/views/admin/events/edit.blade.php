@extends('layouts.admin')

@section('title', ' | EDIT_RECORD // EVNT-' . $event->id)

@section('content')

@if ($errors->any())
    <div class="bg-error-container text-on-error-container border-[4px] border-error p-4 mb-8 font-label-mono text-label-mono">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.events.update', $event->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Header Section -->
    <header class="mb-12 border-b-4 border-on-surface pb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <a class="inline-flex items-center gap-2 font-label-bold text-label-bold text-on-surface hover:text-primary transition-colors mb-4 uppercase" href="{{ route('admin.events.index') }}">
                <span class="material-symbols-outlined">arrow_back_ios_new</span>
                RETURN_TO_INDEX
            </a>
            <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg uppercase text-on-surface tracking-tighter">
                EDIT_RECORD // <span class="bg-secondary-container px-2 inline-block border-[4px] border-on-background transform -rotate-2 ml-2">EVNT-{{ $event->id }}</span>
            </h1>
        </div>
    </header>

    <!-- Asymmetrical Grid Canvas -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter mx-auto pb-32">
        <!-- Left Column (70%) -->
        <div class="lg:col-span-8 flex flex-col gap-8">
            <!-- Input: EVENT_TITLE -->
            <div class="flex flex-col gap-2">
                <label class="font-label-bold text-label-bold uppercase flex items-center gap-2">
                    <span class="w-3 h-3 bg-primary-container inline-block border-2 border-on-surface"></span>
                    EVENT_TITLE
                </label>
                <input name="title" class="w-full bg-surface-container-lowest border-[4px] border-on-background p-4 font-headline-md text-headline-md uppercase transition-all shadow-[4px_4px_0px_0px_#1a1c1c] focus:shadow-[4px_4px_0px_0px_#39ff14] outline-none" type="text" value="{{ old('title', $event->title) }}" required />
            </div>

            <!-- Input: IMAGE_SOURCE_URL -->
            <div class="flex flex-col gap-2">
                <label class="font-label-bold text-label-bold uppercase flex items-center gap-2">
                    <span class="w-3 h-3 bg-primary-container inline-block border-2 border-on-surface"></span>
                    IMAGE_SOURCE_URL
                </label>
                <div class="relative flex">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-tertiary">link</span>
                    <input name="image_path" class="w-full bg-surface-container-lowest border-[4px] border-on-background p-4 pl-12 font-body-lg text-body-lg transition-all shadow-[4px_4px_0px_0px_#1a1c1c] outline-none font-mono" type="url" value="{{ old('image_path', $event->image_path) }}" />
                </div>
            </div>

            <!-- Textarea: EVENT_CONTENT -->
            <div class="flex flex-col gap-2 flex-grow">
                <label class="font-label-bold text-label-bold uppercase flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-primary-container inline-block border-2 border-on-surface"></span>
                        EVENT_CONTENT // RAW_DATA
                    </span>
                    <span class="font-label-mono text-label-mono text-tertiary">FORMAT: JSON/MD</span>
                </label>
                <div class="relative flex-grow flex flex-col h-[500px]">
                    <!-- Editor Toolbar -->
                    <div class="bg-inverse-surface text-on-secondary p-2 flex gap-4 border-t-4 border-l-4 border-r-4 border-on-surface font-label-mono text-label-mono">
                        <button type="button" class="hover:text-primary-container">format</button>
                        <button type="button" class="hover:text-primary-container">validate</button>
                        <span class="opacity-50 mx-auto">||</span>
                        <span class="text-primary-fixed-dim">SYNTAX_OK</span>
                    </div>
                    <textarea name="content" class="w-full flex-grow bg-[#1e1e1e] text-primary-fixed border-4 border-on-surface p-4 font-body-md text-body-md font-mono resize-y focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#39ff14] transition-all shadow-block-black" spellcheck="false" required>{{ old('content', $event->content) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Right Column (30%) -->
        <div class="lg:col-span-4 flex flex-col gap-8">
            <!-- Box: CURRENT_STATE -->
            <div class="bg-surface-container-lowest border-[4px] border-on-background shadow-block-black p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 bg-surface-variant transform rotate-45 translate-x-8 -translate-y-8 border-l-4 border-b-4 border-on-surface"></div>
                <h3 class="font-headline-sm text-headline-sm uppercase mb-6 flex items-center gap-2 border-b-4 border-on-surface pb-2">
                    <span class="material-symbols-outlined">info</span>
                    SYS_STATE
                </h3>
                <div class="flex flex-col gap-4 font-label-mono text-label-mono">
                    <div class="flex justify-between items-center border-b-2 border-dashed border-on-surface-variant pb-2">
                        <span class="text-tertiary">CREATED_AT:</span>
                        <span class="font-bold">{{ $event->created_at->format('Y-m-d_H:i\Z') }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b-2 border-dashed border-on-surface-variant pb-2">
                        <span class="text-tertiary">LAST_MODIFIED:</span>
                        <span class="bg-secondary-container px-2 border-2 border-on-surface font-bold">{{ $event->updated_at->format('Y-m-d_H:i\Z') }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b-2 border-dashed border-on-surface-variant pb-2">
                        <span class="text-tertiary">AUTHOR_NAME:</span>
                        <span class="font-bold">{{ $event->author_name }}</span>
                    </div>
                </div>
            </div>

            <!-- Input: AUTHOR_NAME -->
            <div class="flex flex-col gap-2">
                <label class="font-label-bold text-label-bold uppercase flex items-center gap-2">
                    AUTHOR_NAME
                </label>
                <div class="relative">
                    <input name="author_name" class="w-full bg-surface-container-lowest border-[4px] border-on-background p-4 font-body-md text-body-md shadow-[4px_4px_0px_0px_#1a1c1c] focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#39ff14] transition-all" type="text" value="{{ old('author_name', $event->author_name) }}" placeholder="[ OPTIONAL ]" />
                </div>
            </div>

            <!-- Input: SOURCE_URL -->
            <div class="flex flex-col gap-2">
                <label class="font-label-bold text-label-bold uppercase flex items-center gap-2">
                    SOURCE_URL
                </label>
                <div class="relative">
                    <input name="source_url" class="w-full bg-surface-container-lowest border-[4px] border-on-background p-4 font-body-md text-body-md shadow-[4px_4px_0px_0px_#1a1c1c] focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#39ff14] transition-all" type="url" value="{{ old('source_url', $event->source_url) }}" placeholder="[ OPTIONAL ]" />
                </div>
            </div>

            <!-- Input: PUBLISH_DATE -->
            <div class="flex flex-col gap-2">
                <label class="font-label-bold text-label-bold uppercase flex items-center gap-2">
                    PUBLISH_DATE
                </label>
                <div class="relative">
                    <input name="publish_date" class="w-full bg-surface-container-lowest border-[4px] border-on-background p-4 font-body-md text-body-md uppercase shadow-[4px_4px_0px_0px_#1a1c1c] focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#39ff14] transition-all cursor-pointer" type="date" value="{{ old('publish_date', $event->publish_date ? $event->publish_date->format('Y-m-d') : '') }}" required />
                </div>
            </div>
        </div>
    </div>

    <!-- Fixed Bottom Action Bar -->
    <div class="fixed bottom-0 left-0 right-0 bg-surface-container-lowest border-t-4 border-on-surface p-4 md:p-6 z-40 flex flex-col md:flex-row justify-end items-center gap-4 shadow-[0px_-8px_0px_0px_rgba(0,0,0,0.1)]">
        <a href="{{ route('admin.events.index') }}" class="w-full md:w-auto bg-surface-container-lowest border-[4px] border-on-background shadow-block-black px-8 py-4 font-label-bold text-label-bold uppercase flex items-center justify-center gap-2 hover:bg-surface-variant transition-colors hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-[4px_4px_0px_0px_#1a1c1c]">
            <span class="material-symbols-outlined">close</span>
            CANCEL_EDIT
        </a>
        <button type="submit" class="w-full md:w-auto bg-secondary-container border-[4px] border-on-background shadow-block-yellow px-12 py-4 font-headline-sm text-headline-sm uppercase flex items-center justify-center gap-3 hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-[4px_4px_0px_0px_#f3e300] transition-all">
            <span class="material-symbols-outlined">database</span>
            UPDATE_DATABASE_RECORD
        </button>
    </div>
</form>

<div class="pb-24"></div> <!-- Padding to offset fixed footer -->

@endsection
