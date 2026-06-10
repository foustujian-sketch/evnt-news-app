<aside id="admin-sidebar" class="fixed md:sticky top-0 left-0 z-[60] w-[260px] h-screen bg-surface-container-lowest border-r-4 border-on-background flex flex-col justify-between shadow-[8px_0px_0px_0px_#000000] transition-transform duration-300 transform -translate-x-full md:translate-x-0">
    <!-- Top Brand Header -->
    <div class="p-4 pb-0">
        <div class="border-4 border-on-background bg-surface-container-lowest p-4 neo-shadow-green mb-4">
            <h1 class="font-headline-md text-headline-md text-on-background uppercase break-all leading-none mb-2">
                &gt;_SYS_<br/>ADMIN
            </h1>
            <p class="font-label-mono text-label-mono text-on-surface-variant uppercase flex items-center">
                ROOT_ACCESS_GRANTED<span class="inline-block w-2 h-3 bg-on-background ml-1 cursor-blink"></span>
            </p>
        </div>
    </div>
    
    <!-- Navigation Links -->
    <nav class="flex-1 px-4 overflow-y-auto pt-4 space-y-2">
        <a class="flex items-center p-3 font-label-bold text-label-bold uppercase {{ request()->is('admin/dashboard') ? 'bg-primary-container text-on-background border-4 border-on-background neo-active' : 'text-on-surface-variant border-4 border-transparent hover:bg-surface-container-highest hover:text-on-background hover:border-on-background neo-interact' }} transition-transform block" href="/admin/dashboard">
            <span class="material-symbols-outlined mr-3">dashboard</span>
            [ DASHBOARD ]
        </a>
        <a class="flex items-center p-3 font-label-bold text-label-bold uppercase {{ request()->is('admin/events*') ? 'bg-primary-container text-on-background border-4 border-on-background neo-active' : 'text-on-surface-variant border-4 border-transparent hover:bg-surface-container-highest hover:text-on-background hover:border-on-background neo-interact' }} transition-transform block" href="/admin/events">
            <span class="material-symbols-outlined mr-3">event</span>
            MANAGE_EVENTS
        </a>
        <a class="flex items-center p-3 font-label-bold text-label-bold uppercase {{ request()->is('admin/users*') ? 'bg-primary-container text-on-background border-4 border-on-background neo-active' : 'text-on-surface-variant border-4 border-transparent hover:bg-surface-container-highest hover:text-on-background hover:border-on-background neo-interact' }} transition-transform block" href="/admin/users">
            <span class="material-symbols-outlined mr-3">group</span>
            USER_DATABASE
        </a>
        <a class="flex items-center p-3 font-label-bold text-label-bold uppercase {{ request()->is('admin/comments*') ? 'bg-primary-container text-on-background border-4 border-on-background neo-active' : 'text-on-surface-variant border-4 border-transparent hover:bg-surface-container-highest hover:text-on-background hover:border-on-background neo-interact' }} transition-transform block" href="/admin/comments">
            <span class="material-symbols-outlined mr-3">gavel</span>
            MODERATE_COMMENTS
        </a>
        <a class="flex items-center p-3 font-label-bold text-label-bold uppercase {{ request()->is('admin/api-sync') ? 'bg-primary-container text-on-background border-4 border-on-background neo-active' : 'text-on-surface-variant border-4 border-transparent hover:bg-surface-container-highest hover:text-on-background hover:border-on-background neo-interact' }} transition-transform block" href="/admin/api-sync">
            <span class="material-symbols-outlined mr-3" style="font-variation-settings: 'FILL' 1;">sync</span>
            NEWS_API_SYNC
        </a>
    </nav>
    
    <!-- Footer Action -->
    <div class="border-t-4 border-on-background p-gutter bg-surface-container-lowest mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center p-4 font-label-bold text-label-bold uppercase bg-surface-container-lowest text-on-background border-4 border-on-background hover:bg-error hover:text-on-error neo-interact transition-all group">
                <span class="material-symbols-outlined mr-2 group-hover:text-on-error">logout</span>
                END_SESSION
            </button>
        </form>
    </div>
</aside>
