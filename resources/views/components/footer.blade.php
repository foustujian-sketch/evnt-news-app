<footer class="w-full border-t-[4px] border-on-background bg-surface-container-highest mt-24 flex flex-col">
    <div class="w-full px-margin-mobile md:px-margin-desktop py-12 flex flex-col lg:flex-row justify-between gap-12">
        
        <!-- Left Side: Branding & Status -->
        <div class="flex flex-col gap-4">
            <h3 class="font-headline-md text-headline-md uppercase text-on-background flex items-center gap-3">
                <span class="material-symbols-outlined text-[40px] text-primary" style="font-variation-settings: 'FILL' 1;">terminal</span>
                &gt;_EVNT_SYS
            </h3>
            <div class="flex flex-wrap gap-4">
                <span class="bg-surface-container-lowest border-[2px] border-on-background px-3 py-1 font-label-mono text-label-mono uppercase text-on-surface shadow-[2px_2px_0px_0px_#1a1c1c]">SYS_STATUS: OK</span>
                <span class="bg-surface-container-lowest border-[2px] border-on-background px-3 py-1 font-label-mono text-label-mono uppercase text-on-surface shadow-[2px_2px_0px_0px_#1a1c1c]">LOC: GLOBAL</span>
                <span class="bg-primary-container border-[2px] border-on-background px-3 py-1 font-label-mono text-label-mono uppercase text-on-primary-container shadow-[2px_2px_0px_0px_#1a1c1c] flex items-center gap-2">
                    <span class="w-2 h-2 bg-on-background inline-block rounded-full animate-pulse"></span>
                    ONLINE
                </span>
            </div>
            <p class="font-label-mono text-label-mono text-tertiary mt-2">©{{ date('Y') }} EVNT_CORE_SYSTEMS</p>
            <div class="mt-4 bg-error-container border-[4px] border-on-background p-4 shadow-[4px_4px_0px_0px_#1a1c1c] max-w-md">
                <p class="font-label-bold text-label-bold uppercase text-on-error-container mb-2">
                    <span class="material-symbols-outlined text-[16px] inline-block align-text-bottom">bug_report</span>
                    FOUND A BUG? OR JUST WANNA SAY HI?
                </p>
                <p class="font-label-mono text-label-mono text-on-error-container opacity-80 mb-4">
                    This platform was custom-built from the ground up. If you spot an error, glitch, or security flaw, patch it through to the developer.
                </p>
                <a href="mailto:foustujian@gmail.com" class="inline-block bg-on-background text-error-container px-4 py-2 font-label-bold text-label-bold uppercase hover:bg-error hover:text-on-error transition-colors">
                    >> CONTACT_DEVELOPER
                </a>
            </div>
        </div>

        <!-- Right Side: Social Links -->
        <div class="flex flex-col gap-4">
            <h4 class="font-label-bold text-label-bold uppercase text-on-surface-variant flex items-center gap-2">
                <span class="w-2 h-2 bg-on-background inline-block"></span>
                EXTERNAL_LINKS
            </h4>
            <div class="flex flex-wrap gap-4">
                <!-- GITHUB -->
                <a href="https://github.com/foustujian-sketch" target="_blank" class="flex items-center gap-2 px-6 py-3 bg-surface-container-lowest border-[4px] border-on-background font-label-bold text-label-bold uppercase text-on-surface shadow-[4px_4px_0px_0px_#1a1c1c] hover:translate-x-1 hover:translate-y-1 hover:shadow-none hover:bg-secondary-fixed transition-all">
                    GITHUB
                    <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                </a>
                
                <!-- LINKEDIN -->
                <a href="https://www.linkedin.com/in/abdurrahman-al-farisy-580885328/" target="_blank" class="flex items-center gap-2 px-6 py-3 bg-surface-container-lowest border-[4px] border-on-background font-label-bold text-label-bold uppercase text-on-surface shadow-[4px_4px_0px_0px_#1a1c1c] hover:translate-x-1 hover:translate-y-1 hover:shadow-none hover:bg-[#0a66c2] hover:text-white transition-all">
                    LINKEDIN
                    <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                </a>
                
                <!-- WHATSAPP -->
                <a href="https://wa.me/6285828237918" target="_blank" class="flex items-center gap-2 px-6 py-3 bg-surface-container-lowest border-[4px] border-on-background font-label-bold text-label-bold uppercase text-on-surface shadow-[4px_4px_0px_0px_#1a1c1c] hover:translate-x-1 hover:translate-y-1 hover:shadow-none hover:bg-[#25D366] hover:text-white transition-all">
                    WHATSAPP
                    <span class="material-symbols-outlined text-[18px]">chat</span>
                </a>
            </div>
        </div>
        
    </div>
    
    <!-- Brutalist marquee -->
    <div class="w-full bg-on-background text-primary-container font-label-mono text-label-mono uppercase overflow-hidden border-t-[4px] border-on-background py-3 select-none flex">
        <div class="flex whitespace-nowrap animate-marquee gap-8 w-max">
            @for($i = 0; $i < 60; $i++)
                <span>// BUILD_FAST</span>
                <span>// HACK_THE_PLANET</span>
                <span>// SHIP_CODE</span>
            @endfor
        </div>
    </div>
</footer>
