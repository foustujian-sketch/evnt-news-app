<nav class="sticky top-0 z-50 flex items-center px-margin-mobile md:px-margin-desktop py-4 bg-background w-full border-b-border-width border-on-background shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] gap-4 md:gap-8">
    <!-- Brand Logo from ARTICLE_DETAIL -->
    <a href="/" class="flex items-center justify-center shrink-0 font-headline-md text-[28px] md:text-[32px] leading-none bg-surface-container-lowest border-4 border-on-surface shadow-[4px_4px_0px_0px_#39ff14] px-2 py-2 text-on-surface hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all duration-100">
        &gt;_EVNT
    </a>

    <!-- Navigation Links (Hidden on Mobile) -->
    <div class="hidden md:flex gap-6 items-center shrink-0">
        <a class="text-on-background font-label-bold text-label-bold border-[3px] border-transparent hover:border-on-background hover:bg-primary-container hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-1 hover:-translate-x-1 transition-all active:translate-x-0 active:translate-y-0 active:shadow-none py-1 px-3 uppercase" href="{{ url('/?q=hackathon#feed') }}">HACKATHONS</a>
        <a class="text-on-background font-label-bold text-label-bold border-[3px] border-transparent hover:border-on-background hover:bg-primary-container hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-1 hover:-translate-x-1 transition-all active:translate-x-0 active:translate-y-0 active:shadow-none py-1 px-3 uppercase" href="{{ url('/?q=workshop#feed') }}">WORKSHOPS</a>
        
        @include('components.calendar-picker')
    </div>

    <div class="flex flex-1 items-center justify-end gap-4 min-w-0">
        <!-- Search Bar -->
        <form method="GET" action="{{ url('/') }}#feed" class="hidden md:flex flex-1 w-full max-w-xl mr-4 group">
            <div class="flex w-full shadow-[4px_4px_0px_0px_#1a1c1c] group-hover:translate-x-1 group-hover:translate-y-1 group-hover:shadow-none transition-all">
                <input name="q" value="{{ request('q') }}" class="w-full bg-surface-container-lowest border-[4px] border-r-0 border-on-background px-4 py-2 font-label-bold text-label-bold focus:outline-none focus:ring-0 text-on-surface placeholder-tertiary" placeholder="SEARCH_YOUR_NEWS_HERE..." type="text">
                <button type="submit" class="bg-surface-container-lowest text-on-surface border-[4px] border-l-0 border-on-background px-4 py-2 flex items-center justify-center hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined">search</span>
                </button>
            </div>
        </form>

        @auth
            <!-- Notification Bell -->
            <div class="relative group">
                <button id="notification-btn" class="brutal-btn bg-secondary-fixed text-on-secondary-fixed font-label-bold text-label-bold uppercase border-border-width border-on-background w-12 h-12 shadow-[4px_4px_0px_0px_#1a1c1c] flex items-center justify-center relative">
                    <span class="material-symbols-outlined">notifications</span>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="absolute -top-2 -right-2 bg-error text-on-error border-2 border-on-background w-6 h-6 flex items-center justify-center text-xs shadow-[2px_2px_0px_0px_#1a1c1c]">
                            {{ Auth::user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </button>
                
                <!-- Dropdown -->
                <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-surface-container-lowest border-[4px] border-on-background shadow-[8px_8px_0px_0px_#1a1c1c] z-[100] flex flex-col max-h-[80vh] overflow-hidden">
                    <div class="bg-on-background text-on-primary p-3 font-label-bold text-label-bold uppercase flex justify-between items-center shrink-0">
                        <span>SYS_NOTIFICATIONS</span>
                        <form method="POST" action="{{ route('notifications.readAll') }}" class="m-0">
                            @csrf
                            <button type="submit" class="text-xs hover:text-primary-container transition-colors focus:outline-none">[ CLEAR ]</button>
                        </form>
                    </div>
                    <div class="overflow-y-auto font-body-md text-body-md flex flex-col divide-y-[4px] divide-on-background">
                        @forelse(Auth::user()->notifications as $notification)
                            <div class="p-4 {{ $notification->read_at ? 'bg-surface-container-lowest opacity-70' : 'bg-surface-container' }} flex flex-col gap-2 relative">
                                @if(!$notification->read_at)
                                    <div class="w-2 h-2 bg-primary-container absolute left-2 top-6"></div>
                                @endif
                                <p class="pl-2 text-sm leading-tight"><span class="font-label-mono text-tertiary">[{{ $notification->created_at->format('H:i') }}]</span> {{ $notification->data['message'] ?? 'SYSTEM_ALERT' }}</p>
                                @if(isset($notification->data['action_url']))
                                    <a href="{{ $notification->data['action_url'] }}" class="text-primary hover:underline text-xs font-label-bold uppercase pl-2">>> VIEW_DETAILS</a>
                                @endif
                            </div>
                        @empty
                            <div class="p-8 text-center text-tertiary font-label-mono uppercase">NO_ALERTS</div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <script>
                document.getElementById('notification-btn').addEventListener('click', function(e) {
                    const dropdown = document.getElementById('notification-dropdown');
                    dropdown.classList.toggle('hidden');
                    e.stopPropagation();
                });
                document.addEventListener('click', function(e) {
                    const dropdown = document.getElementById('notification-dropdown');
                    const btn = document.getElementById('notification-btn');
                    if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            </script>

            <!-- Logged In State (Avatar Profile) -->
            <a href="/dashboard" class="brutal-btn bg-surface-container-highest border-border-width border-on-background shadow-[4px_4px_0px_0px_#1a1c1c] flex items-center justify-center w-12 h-12 overflow-hidden">
                <img src="{{ Auth::user()->avatar_url }}" alt="Profile" class="w-full h-full object-cover">
            </a>
        @else
            <!-- Guest State -->
            <a class="font-label-bold text-label-bold text-on-surface bg-surface-container-highest border-4 border-on-surface shadow-[4px_4px_0px_0px_#1a1c1c] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all duration-100 px-4 py-2" href="/login">
                [ INIT_LOGIN ]
            </a>
        @endauth
    </div>
</nav>
