@extends('layouts.app')

@section('title', ' | ' . $event->title)
@section('meta_description', Str::limit(strip_tags($event->content), 150))
@if($event->image_path)
    @section('meta_image', $event->image_path)
@endif

@section('content')
<!-- Top Action Bar (Back Button Fix) -->
<div class="mb-8">
    <a href="/" class="brutal-btn inline-flex items-center gap-2 bg-secondary-fixed text-on-secondary-fixed border-border-width border-on-background px-6 py-3 font-label-bold text-label-bold uppercase shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">arrow_back_ios</span>
        [ &lt;_ABORT_AND_RETURN ]
    </a>
</div>

<!-- Article Header -->
<article class="flex flex-col gap-8">
    <div class="w-full h-[400px] md:h-[600px] border-[4px] border-on-background shadow-[8px_8px_0px_0px_#000] overflow-hidden relative bg-surface-container-lowest flex items-center justify-center">
        @if($event->image_path)
            <img alt="{{ $event->title }}" class="w-full h-full object-cover" src="{{ $event->image_path }}">
            <div class="absolute bottom-4 right-4 bg-white border-[4px] border-on-background p-2 font-label-mono text-label-mono z-10">
                IMG_SRC_001
            </div>
        @else
            <!-- Fallback Image -->
            <div class="text-center">
                <span class="material-symbols-outlined text-8xl text-primary-container mb-4" style="font-variation-settings: 'FILL' 1;">image_not_supported</span>
                <h2 class="font-headline-md uppercase bg-white border-4 border-on-background px-4 py-2 shadow-[4px_4px_0px_0px_#000]">NO_IMAGE_DATA</h2>
            </div>
        @endif
    </div>
    <div class="flex flex-col md:flex-row gap-8 items-start">
        <div class="mb-8">
            <h1 class="font-headline-xl text-headline-lg-mobile md:font-headline-xl text-on-surface uppercase mb-4 leading-none">
                {{ $event->title }}
            </h1>
            <div class="flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
                <div class="bg-secondary-container text-on-background px-3 py-1 font-label-mono text-label-mono border-2 border-on-background uppercase shadow-[2px_2px_0px_0px_#000]">
                    DATE: {{ $event->publish_date->format('Y-m-d') }}
                </div>
                
                @auth
                    @php
                        $isSaved = Auth::user()->savedEvents()->where('event_news_id', $event->id)->exists();
                    @endphp
                    <button id="save-event-btn" class="brutal-btn {{ $isSaved ? 'bg-error text-on-error' : 'bg-primary text-on-background' }} border-border-width border-on-background px-8 py-3 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] font-label-bold text-label-bold uppercase flex items-center justify-center gap-2 hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all w-full md:w-auto">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $isSaved ? '1' : '0' }};">
                            {{ $isSaved ? 'bookmark_remove' : 'save' }}
                        </span>
                        <span id="save-event-text">
                            {{ $isSaved ? '[ REMOVE_FROM_PROFILE ]' : '[ SAVE_EVENT_TO_PROFILE ]' }}
                        </span>
                    </button>
                    
                    <script>
                        document.getElementById('save-event-btn').addEventListener('click', async function() {
                            const btn = this;
                            const textSpan = document.getElementById('save-event-text');
                            const iconSpan = btn.querySelector('.material-symbols-outlined');
                            
                            btn.disabled = true;
                            const originalText = textSpan.innerText;
                            textSpan.innerText = 'PROCESSING...';
                            
                            try {
                                const response = await fetch('{{ route("events.save", $event->id) }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        'Accept': 'application/json'
                                    }
                                });
                                
                                if (response.ok) {
                                    const data = await response.json();
                                    if (data.is_saved) {
                                        btn.classList.remove('bg-primary', 'text-on-background');
                                        btn.classList.add('bg-error', 'text-on-error');
                                        textSpan.innerText = '[ REMOVE_FROM_PROFILE ]';
                                        iconSpan.innerText = 'bookmark_remove';
                                        iconSpan.style.fontVariationSettings = "'FILL' 1";
                                    } else {
                                        btn.classList.remove('bg-error', 'text-on-error');
                                        btn.classList.add('bg-primary', 'text-on-background');
                                        textSpan.innerText = '[ SAVE_EVENT_TO_PROFILE ]';
                                        iconSpan.innerText = 'save';
                                        iconSpan.style.fontVariationSettings = "'FILL' 0";
                                    }
                                } else {
                                    textSpan.innerText = originalText;
                                    alert('Error toggling save status.');
                                }
                            } catch(err) {
                                console.error(err);
                                textSpan.innerText = originalText;
                                alert('Network error.');
                            } finally {
                                btn.disabled = false;
                            }
                        });
                    </script>
                @endauth
            </div>
        </div>
        <div class="bg-surface border-[4px] border-on-background shadow-[8px_8px_0px_0px_#000] p-6 w-full md:w-auto md:min-w-[300px] shrink-0 flex flex-col gap-4 font-label-mono text-label-mono">
            <div class="flex flex-col border-b-4 border-on-surface pb-2">
                <span class="text-tertiary">AUTHOR:</span>
                <span class="font-label-bold text-label-bold uppercase text-on-surface">{{ $event->author_name }}</span>
            </div>
            <div class="flex flex-col border-b-4 border-on-surface pb-2">
                <span class="text-tertiary">DATE:</span>
                <span class="font-label-bold text-label-bold uppercase text-on-surface">{{ $event->publish_date->format('Y-m-d') }}</span>
            </div>
            <a href="{{ $event->source_url }}" target="_blank" class="w-full bg-secondary-fixed text-on-secondary-fixed border-[4px] border-on-background brutal-btn py-3 mt-2 text-center flex justify-center items-center gap-2 hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all shadow-[4px_4px_0px_0px_#000]">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">open_in_new</span>
                VIEW_ORIGINAL_SOURCE
            </a>
        </div>
    </div>
</article>

<!-- Content Area -->
<div class="font-body-lg text-body-lg max-w-4xl mx-auto w-full flex flex-col gap-6 tracking-tight leading-relaxed mt-12">
    <p class="">
        {{ $event->content }}
    </p>
    <div class="my-8 border-[4px] border-on-background p-6 bg-surface-container-low shadow-[8px_8px_0px_0px_#000] border-l-8 border-l-primary-container">
        <p class="font-label-bold text-label-bold uppercase text-on-surface mb-2">&gt;&gt; SYSTEM_NOTE</p>
        <p class="font-body-md text-body-md">
            This event data was automatically aggregated via the NewsAPI. Full content may require visiting the original source.
        </p>
    </div>
</div>



<!-- Comment Section -->
<section class="max-w-4xl mx-auto w-full flex flex-col gap-8">
    <h2 class="font-headline-md text-headline-md uppercase">&gt;_USER_COMMENTS</h2>
    
    @auth
        <form id="comment-form" class="flex flex-col gap-4">
            @csrf
            <textarea id="comment-content" name="content" class="w-full brutal-input bg-white brutal-border brutal-shadow-black p-4 font-body-md text-body-md transition-colors resize-y" placeholder="WRITE_COMMENT..." rows="4" required></textarea>
            <div class="flex justify-end">
                <button class="bg-white text-on-surface brutal-btn py-2 px-6" type="submit" id="submit-comment-btn">
                    SUBMIT_QUERY
                </button>
            </div>
        </form>

        <script>
            document.getElementById('comment-form').addEventListener('submit', async function(e) {
                e.preventDefault();
                const content = document.getElementById('comment-content').value;
                const btn = document.getElementById('submit-comment-btn');
                
                if (!content.trim()) return;
                
                btn.innerText = 'PROCESSING...';
                btn.disabled = true;

                try {
                    const response = await fetch('{{ route("comments.store", $event->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ content: content })
                    });

                    if (response.ok) {
                        const data = await response.json();
                        
                        // Create new comment element
                        const commentsList = document.getElementById('comments-list');
                        
                        // Remove empty state if present
                        const emptyState = document.getElementById('empty-comments');
                        if (emptyState) emptyState.remove();

                        const newComment = document.createElement('div');
                        newComment.className = 'bg-surface brutal-border p-6 relative opacity-0 translate-y-4 transition-all duration-500 ease-out flex gap-6';
                        newComment.innerHTML = `
                            <div class="absolute -top-4 left-4 bg-white brutal-border px-2 py-1 font-label-mono text-label-mono flex items-center gap-2">
                                <div class="w-2 h-2 bg-primary-container"></div>
                                USER_ID: ${data.user_id}
                            </div>
                            <img src="${data.avatar_url}" class="w-16 h-16 brutal-border bg-surface-container-highest shrink-0" alt="Avatar">
                            <p class="font-body-md text-body-md mt-2 flex-1">${data.content}</p>
                        `;

                        // Add to top of list
                        commentsList.insertBefore(newComment, commentsList.firstChild);
                        
                        // Trigger animation
                        setTimeout(() => {
                            newComment.classList.remove('opacity-0', 'translate-y-4');
                        }, 50);

                        // Reset form
                        document.getElementById('comment-content').value = '';
                    } else {
                        alert('Error submitting comment.');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Network error.');
                } finally {
                    btn.innerText = 'SUBMIT_QUERY';
                    btn.disabled = false;
                }
            });
        </script>
    @endauth

    @guest
        <div class="bg-surface-container-low brutal-border p-6 text-center">
            <p class="font-body-md text-body-md mb-4 text-tertiary">SYSTEM_ERROR: Unauthorized access to comment posting module.</p>
            <div class="flex flex-col md:flex-row justify-center items-center gap-4">
                <a href="{{ route('login') }}" class="bg-white text-on-surface brutal-btn py-3 px-6 font-label-bold uppercase w-full md:w-auto text-center border-[4px] border-on-background shadow-[4px_4px_0px_0px_#1a1c1c]">
                    LOGIN_TO_COMMENT
                </a>
                <a href="{{ route('register') }}" class="bg-primary-container text-on-primary-container brutal-btn py-3 px-6 font-label-bold uppercase w-full md:w-auto text-center border-[4px] border-on-background shadow-[4px_4px_0px_0px_#1a1c1c]">
                    REGISTER_ACCOUNT
                </a>
            </div>
        </div>
    @endguest

    <div id="comments-list" class="flex flex-col gap-6 mt-8">
        <!-- Live comments will be rendered here -->
        @forelse($event->comments ?? [] as $comment)
            <div class="bg-surface brutal-border p-6 relative flex gap-6">
                <div class="absolute -top-4 left-4 bg-white brutal-border px-2 py-1 font-label-mono text-label-mono flex items-center gap-2">
                    <div class="w-2 h-2 bg-primary-container"></div>
                    USER_ID: {{ strtoupper(substr(md5($comment->user->id), 0, 4)) }}
                </div>
                <img src="{{ $comment->user->avatar_url }}" class="w-16 h-16 brutal-border bg-surface-container-highest shrink-0" alt="Avatar">
                <p class="font-body-md text-body-md mt-2 flex-1">
                    {{ $comment->body }}
                </p>
            </div>
        @empty
            <div id="empty-comments" class="text-center font-label-mono text-tertiary py-8 border-[4px] border-on-background border-dashed">
                NO_COMMENTS_FOUND // BE_THE_FIRST
            </div>
        @endforelse
    </div>
</section>
@endsection
