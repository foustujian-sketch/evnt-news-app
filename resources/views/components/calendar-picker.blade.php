<style>
    .brutalist-card-cal {
        border: 4px solid #1a1c1c;
        box-shadow: 8px 8px 0px 0px rgba(0, 0, 0, 1);
        transition: transform 0.1s ease-in-out, box-shadow 0.1s ease-in-out;
    }
    .brutalist-button-cal {
        border: 2px solid #1a1c1c;
        box-shadow: 4px 4px 0px 0px rgba(0, 0, 0, 1);
        transition: transform 0.1s ease-in-out, box-shadow 0.1s ease-in-out;
    }
    .brutalist-button-cal:active {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 1);
    }
    .calendar-cell {
        border: 1px solid #1a1c1c;
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.05s ease-in-out, box-shadow 0.05s ease-in-out, background-color 0.1s;
    }
    .calendar-cell:hover:not(.empty) {
        background-color: #79ff5b;
        transform: translate(-2px, -2px);
        box-shadow: 2px 2px 0px 0px rgba(0, 0, 0, 1);
    }
    .calendar-cell:active:not(.empty) {
        transform: translate(0px, 0px);
        box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 1);
    }
    .cyber-yellow { background-color: #f6e600; }
</style>

<div class="relative group" id="calendar-widget">
    <!-- Trigger Button -->
    <button type="button" class="flex items-center gap-2 border-[3px] border-transparent hover:border-on-background hover:bg-primary-container hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-1 hover:-translate-x-1 transition-all active:translate-x-0 active:translate-y-0 active:shadow-none py-1 px-3 uppercase font-label-bold text-label-bold text-on-background">
        <span class="material-symbols-outlined text-[18px]">calendar_month</span>
        CALENDAR
    </button>

    <!-- Dropdown (Hidden by default, shown on hover/focus within group) -->
    <div class="absolute right-0 top-full mt-2 w-[340px] brutalist-card-cal bg-surface p-4 flex-col gap-4 z-50 hidden group-hover:flex shadow-[8px_8px_0px_0px_#1a1c1c]">
        
        <!-- Header Section -->
        <div class="flex items-center justify-between border-b-4 border-on-surface pb-3">
            <h2 id="cal-month-year" class="font-label-bold text-headline-sm uppercase tracking-tighter text-on-background m-0 leading-none">JUNE 2026</h2>
            <div class="flex gap-2">
                <button type="button" id="cal-prev" class="brutalist-button-cal p-1 bg-surface-container-high hover:bg-primary-fixed text-on-background flex items-center justify-center">
                    <span class="material-symbols-outlined text-headline-sm">chevron_left</span>
                </button>
                <button type="button" id="cal-next" class="brutalist-button-cal p-1 bg-surface-container-high hover:bg-primary-fixed text-on-background flex items-center justify-center">
                    <span class="material-symbols-outlined text-headline-sm">chevron_right</span>
                </button>
            </div>
        </div>

        <!-- Calendar Grid Container -->
        <div class="flex flex-col gap-1 mt-4">
            <!-- Days Header -->
            <div class="grid grid-cols-7 gap-1 mb-1">
                <div class="font-label-bold text-label-mono text-center text-on-surface-variant py-1 bg-surface-container-highest border-2 border-on-surface">SU</div>
                <div class="font-label-bold text-label-bold text-center text-on-surface-variant py-1 bg-surface-container-highest border-2 border-on-surface">MO</div>
                <div class="font-label-bold text-label-bold text-center text-on-surface-variant py-1 bg-surface-container-highest border-2 border-on-surface">TU</div>
                <div class="font-label-bold text-label-bold text-center text-on-surface-variant py-1 bg-surface-container-highest border-2 border-on-surface">WE</div>
                <div class="font-label-bold text-label-bold text-center text-on-surface-variant py-1 bg-surface-container-highest border-2 border-on-surface">TH</div>
                <div class="font-label-bold text-label-bold text-center text-on-surface-variant py-1 bg-surface-container-highest border-2 border-on-surface">FR</div>
                <div class="font-label-bold text-label-bold text-center text-on-surface-variant py-1 bg-surface-container-highest border-2 border-on-surface">SA</div>
            </div>
            
            <!-- Grid Cells -->
            <div id="cal-grid" class="grid grid-cols-7 gap-1">
                <!-- Javascript will inject cells here -->
            </div>
        </div>

        <!-- Footer Actions -->
        <div class="flex justify-between items-center mt-4 pt-3 border-t-[3px] border-outline-variant">
            <button type="button" onclick="window.location.href='/#feed'" class="font-label-bold text-label-bold text-error uppercase hover:underline">Clear Filter</button>
            <div class="flex gap-3">
                <button type="button" id="cal-today" class="font-label-bold text-label-bold text-primary uppercase border-b-2 border-primary hover:bg-primary-container transition-colors">Today</button>
            </div>
        </div>

        <!-- Decorative Terminal Element -->
        <div class="bg-on-surface h-6 flex items-center px-2 gap-1.5 -mx-4 -mb-4 mt-2 border-t-[4px] border-on-background">
            <div class="w-2 h-2 rounded-full bg-error"></div>
            <div class="w-2 h-2 rounded-full bg-secondary-fixed"></div>
            <div class="w-2 h-2 rounded-full bg-primary-fixed"></div>
            <span class="font-label-mono text-[10px] text-surface-dim ml-auto">SYS_CALENDAR_V2.0</span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const monthYearText = document.getElementById('cal-month-year');
        const grid = document.getElementById('cal-grid');
        
        let currentDate = new Date();
        // Check if there is an active date in the URL
        const urlParams = new URLSearchParams(window.location.search);
        const selectedDateParam = urlParams.get('date');
        let selectedDate = selectedDateParam ? new Date(selectedDateParam + 'T00:00:00') : null;

        if (selectedDate) {
            currentDate = new Date(selectedDate);
        }

        const renderCalendar = () => {
            grid.innerHTML = '';
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            const monthNames = ["JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", "JULY", "AUGUST", "SEPTEMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];
            monthYearText.textContent = `${monthNames[month]} ${year}`;

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const prevMonthDays = new Date(year, month, 0).getDate();

            // Previous month trailing days
            for (let i = firstDay - 1; i >= 0; i--) {
                const day = prevMonthDays - i;
                const cell = document.createElement('div');
                cell.className = 'calendar-cell empty font-label-bold text-label-bold text-on-surface-variant/40 bg-surface-container-low cursor-default pointer-events-none';
                cell.textContent = day;
                grid.appendChild(cell);
            }

            // Current month days
            for (let i = 1; i <= daysInMonth; i++) {
                const cell = document.createElement('div');
                cell.textContent = i;
                
                const cellDateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                
                // Check if this cell is the selected date
                let isSelected = selectedDate && 
                                 selectedDate.getFullYear() === year && 
                                 selectedDate.getMonth() === month && 
                                 selectedDate.getDate() === i;

                if (isSelected) {
                    cell.className = 'calendar-cell font-label-bold text-label-bold cyber-yellow border-[3px] border-on-surface scale-105 z-10 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] text-on-background';
                } else {
                    cell.className = 'calendar-cell font-label-bold text-label-bold bg-surface text-on-background hover:bg-primary-fixed';
                }

                cell.addEventListener('click', () => {
                    window.location.href = `/?date=${cellDateStr}#feed`;
                });

                grid.appendChild(cell);
            }

            // Next month leading days (fill to 42 cells = 6 rows)
            const totalCells = firstDay + daysInMonth;
            const remaining = 42 - totalCells;
            for (let i = 1; i <= remaining; i++) {
                const cell = document.createElement('div');
                cell.className = 'calendar-cell empty font-label-bold text-label-bold text-on-surface-variant/40 bg-surface-container-low cursor-default pointer-events-none';
                cell.textContent = i;
                grid.appendChild(cell);
            }
        };

        document.getElementById('cal-prev').addEventListener('click', (e) => {
            e.stopPropagation();
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        document.getElementById('cal-next').addEventListener('click', (e) => {
            e.stopPropagation();
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        document.getElementById('cal-today').addEventListener('click', (e) => {
            e.stopPropagation();
            currentDate = new Date();
            renderCalendar();
        });

        renderCalendar();
    });
</script>
