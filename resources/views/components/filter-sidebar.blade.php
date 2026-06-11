<!-- Filter Sidebar Component -->
<div id="filter-sidebar" class="fixed inset-y-0 right-0 w-full sm:w-[450px] bg-surface border-l-[4px] border-on-background shadow-[-16px_0_0_0_rgba(0,0,0,1)] z-[100] transform translate-x-full transition-transform duration-300 flex flex-col">
    
    <!-- Header -->
    <div class="flex justify-between items-center p-6 border-b-[4px] border-on-background bg-secondary-container">
        <h2 class="font-headline-md uppercase text-on-background leading-none flex items-center gap-2">
            <span class="material-symbols-outlined text-[32px]">filter_list</span>
            ADVANCED_FILTERS
        </h2>
        <button type="button" onclick="toggleFilterSidebar()" class="bg-error text-on-error border-[4px] border-on-background p-2 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all flex items-center justify-center">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ url('/') }}#feed" class="flex flex-col flex-1 p-8 overflow-y-auto bg-surface-dim">
        
        <!-- Preserve existing query strings for Search and Date so they stack! -->
        @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
        @if(request('date')) <input type="hidden" name="date" value="{{ request('date') }}"> @endif
        
        <!-- Sort Order -->
        <div class="mb-10 bg-surface border-[4px] border-on-background p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
            <h3 class="font-label-bold text-xl mb-4 uppercase border-b-[3px] border-on-background pb-2 tracking-tighter">SORT_ORDER</h3>
            <div class="flex flex-col gap-4">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="radio" name="sort" value="desc" class="w-6 h-6 border-[3px] border-on-background text-primary-container focus:ring-0 focus:ring-offset-0 checked:bg-on-background" {{ request('sort', 'desc') === 'desc' ? 'checked' : '' }}>
                    <span class="font-label-mono text-lg uppercase group-hover:text-primary transition-colors">NEWEST_FIRST</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="radio" name="sort" value="asc" class="w-6 h-6 border-[3px] border-on-background text-primary-container focus:ring-0 focus:ring-offset-0 checked:bg-on-background" {{ request('sort') === 'asc' ? 'checked' : '' }}>
                    <span class="font-label-mono text-lg uppercase group-hover:text-primary transition-colors">OLDEST_FIRST</span>
                </label>
            </div>
        </div>

        <!-- Tag Selection -->
        <div class="mb-10 flex-1 bg-surface border-[4px] border-on-background p-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]">
            <h3 class="font-label-bold text-xl mb-4 uppercase border-b-[3px] border-on-background pb-2 tracking-tighter">QUICK_TAGS</h3>
            <div class="flex flex-wrap gap-3">
                @php 
                    $tags = ['Hackathon', 'AI', 'Web', 'Cloud', 'Data', 'Security', 'Open Source', 'Startup', 'Workshop']; 
                @endphp
                @foreach($tags as $t)
                    <label class="cursor-pointer">
                        <input type="radio" name="tag" value="{{ $t }}" class="peer sr-only" {{ request('tag') === $t ? 'checked' : '' }}>
                        <div class="bg-surface-container-highest border-[3px] border-on-background px-3 py-1 font-label-mono uppercase hover:-translate-y-1 hover:shadow-[4px_4px_0px_0px_#1a1c1c] transition-all peer-checked:bg-primary-container peer-checked:text-on-background peer-checked:shadow-[4px_4px_0px_0px_#1a1c1c] peer-checked:translate-x-0 peer-checked:translate-y-0">
                            #{{ strtoupper($t) }}
                        </div>
                    </label>
                @endforeach
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="mt-auto flex flex-col gap-4">
            <button type="submit" class="bg-primary-container text-on-background border-[4px] border-on-background px-6 py-4 font-headline-sm uppercase shadow-[8px_8px_0px_0px_#1a1c1c] hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all w-full text-center">
                EXECUTE_FILTERS
            </button>
            <a href="{{ url('/') }}#feed" class="bg-surface-container-high text-on-background border-[4px] border-on-background px-6 py-3 font-label-bold uppercase text-center hover:bg-error hover:text-on-error hover:shadow-[4px_4px_0px_0px_#1a1c1c] transition-all">
                CLEAR_ALL
            </a>
        </div>
    </form>
</div>

<!-- Backdrop Overlay -->
<div id="filter-overlay" onclick="toggleFilterSidebar()" class="fixed inset-0 bg-black/50 z-[90] hidden backdrop-blur-sm transition-opacity duration-300 opacity-0"></div>

<!-- Controller Script -->
<script>
    function toggleFilterSidebar() {
        const sidebar = document.getElementById('filter-sidebar');
        const overlay = document.getElementById('filter-overlay');
        
        if (sidebar.classList.contains('translate-x-full')) {
            // Open
            sidebar.classList.remove('translate-x-full');
            overlay.classList.remove('hidden');
            // Small delay to allow display:block to apply before animating opacity
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');
            }, 10);
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        } else {
            // Close
            sidebar.classList.add('translate-x-full');
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300); // Match transition duration
            document.body.style.overflow = '';
        }
    }
</script>
