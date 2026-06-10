<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name', '>&lowbar;SYS_ADMIN') }} @yield('title')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Tailwind Config -->
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                "surface-container": "#eeeeee",
                "on-secondary-fixed": "#1f1c00",
                "on-primary-fixed-variant": "#095300",
                "surface-container-highest": "#e2e2e2",
                "on-primary-fixed": "#022100",
                "surface-tint": "#106e00",
                "outline": "#6b7c63",
                "background": "#f9f9f9",
                "on-secondary-container": "#6b6400",
                "tertiary-fixed": "#e2e2e2",
                "on-secondary": "#ffffff",
                "primary-fixed": "#79ff5b",
                "on-surface": "#1a1c1c",
                "on-error-container": "#93000a",
                "tertiary-fixed-dim": "#c6c6c6",
                "on-surface-variant": "#3c4b35",
                "inverse-on-surface": "#f0f1f1",
                "on-primary": "#ffffff",
                "surface-container-lowest": "#ffffff",
                "surface-dim": "#dadada",
                "primary": "#106e00",
                "surface-bright": "#f9f9f9",
                "on-tertiary-fixed": "#1b1b1b",
                "secondary-fixed": "#f6e600",
                "primary-fixed-dim": "#2ae500",
                "inverse-primary": "#2ae500",
                "inverse-surface": "#2f3131",
                "error": "#ba1a1a",
                "tertiary": "#5e5e5e",
                "on-tertiary": "#ffffff",
                "on-primary-container": "#107100",
                "outline-variant": "#baccb0",
                "on-tertiary-fixed-variant": "#474747",
                "secondary-container": "#f3e300",
                "primary-container": "#39ff14",
                "secondary-fixed-dim": "#d7ca00",
                "surface-container-low": "#f3f3f4",
                "on-error": "#ffffff",
                "on-tertiary-container": "#616161",
                "tertiary-container": "#dddddd",
                "surface-variant": "#e2e2e2",
                "secondary": "#676000",
                "on-secondary-fixed-variant": "#4d4800",
                "on-background": "#1a1c1c",
                "surface-container-high": "#e8e8e8",
                "error-container": "#ffdad6",
                "surface": "#f9f9f9"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "margin-desktop": "48px",
                    "border-width": "4px",
                    "gutter": "24px",
                    "container-max": "1440px",
                    "shadow-offset": "8px",
                    "margin-mobile": "16px"
            },
            "fontFamily": {
                    "headline-lg": ["Space Grotesk"],
                    "headline-md": ["Space Grotesk"],
                    "headline-xl": ["Space Grotesk"],
                    "headline-lg-mobile": ["Space Grotesk"],
                    "body-lg": ["JetBrains Mono"],
                    "headline-sm": ["Space Grotesk"],
                    "label-bold": ["JetBrains Mono"],
                    "body-md": ["JetBrains Mono"],
                    "label-mono": ["JetBrains Mono"]
            },
            "fontSize": {
                    "headline-lg": ["48px", { "lineHeight": "1.1", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                    "headline-md": ["32px", { "lineHeight": "1.2", "fontWeight": "700" }],
                    "headline-xl": ["80px", { "lineHeight": "1.0", "letterSpacing": "-0.04em", "fontWeight": "700" }],
                    "headline-lg-mobile": ["36px", { "lineHeight": "1.1", "fontWeight": "700" }],
                    "body-lg": ["18px", { "lineHeight": "1.6", "fontWeight": "400" }],
                    "headline-sm": ["24px", { "lineHeight": "1.2", "fontWeight": "700" }],
                    "label-bold": ["14px", { "lineHeight": "1.0", "fontWeight": "700" }],
                    "body-md": ["16px", { "lineHeight": "1.6", "fontWeight": "400" }],
                    "label-mono": ["12px", { "lineHeight": "1.0", "fontWeight": "500" }]
            }
          }
        }
      }
    </script>
    <style>
        .neo-shadow { box-shadow: 8px 8px 0px 0px #000000; }
        .neo-shadow-green { box-shadow: 8px 8px 0px 0px #39FF14; }
        .shadow-block-black { box-shadow: 8px 8px 0px 0px #1a1c1c; }
        .shadow-block-yellow { box-shadow: 8px 8px 0px 0px #f6e600; }
        .shadow-block-green { box-shadow: 8px 8px 0px 0px #39ff14; }

        .neo-interact:hover {
            transform: translate(-4px, -4px);
            box-shadow: 8px 8px 0px 0px #000000;
        }
        .neo-interact:active {
            transform: translate(4px, 4px) !important;
            box-shadow: 0px 0px 0px 0px transparent !important;
        }
        .interactive-element {
            transition: transform 0.1s ease-in-out, box-shadow 0.1s ease-in-out;
        }
        .interactive-element:active {
            transform: translate(4px, 4px);
            box-shadow: 4px 4px 0px 0px transparent !important;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
        .cursor-blink {
            animation: blink 1s step-end infinite;
        }
        .terminal-cursor::after {
            content: "█";
            animation: blink 1s step-end infinite;
            color: #39ff14;
            margin-left: 4px;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md overflow-x-hidden selection:bg-primary-container selection:text-on-background min-h-screen flex flex-col md:flex-row">

    <!-- Mobile Navigation Trigger (Hidden on Desktop) -->
    <div class="md:hidden bg-on-background p-4 border-b-[4px] border-on-surface flex justify-between items-center sticky top-0 z-50">
        <h1 class="font-headline-sm text-headline-sm text-primary-container tracking-tighter uppercase terminal-cursor">&gt;_SYS_ADMIN</h1>
        <button id="admin-menu-toggle" class="text-primary-container p-2 focus:outline-none">
            <span class="material-symbols-outlined text-3xl">menu</span>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('admin-sidebar');
            const toggleBtn = document.getElementById('admin-menu-toggle');
            
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', (e) => {
                    sidebar.classList.toggle('-translate-x-full');
                    e.stopPropagation();
                });
                
                // Close when clicking outside on mobile
                document.addEventListener('click', (e) => {
                    if (window.innerWidth < 768 && !sidebar.contains(e.target) && !toggleBtn.contains(e.target) && !sidebar.classList.contains('-translate-x-full')) {
                        sidebar.classList.add('-translate-x-full');
                    }
                });
            }
        });
    </script>

    @include('components.admin-sidebar')

    <main class="flex-1 min-w-0 p-margin-mobile md:p-margin-desktop bg-background min-h-screen">
        @yield('content')
    </main>

    <!-- Global Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-on-background/80 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm transition-opacity duration-300">
        <div class="bg-surface-container-lowest border-border-width border-on-background shadow-[16px_16px_0px_0px_#ba1a1a] max-w-lg w-full scale-95 transition-transform duration-300 transform modal-content">
            <div class="bg-error text-on-error p-4 border-b-border-width border-on-background flex items-center gap-3">
                <span class="material-symbols-outlined text-[32px]" style="font-variation-settings: 'FILL' 1;">warning</span>
                <h2 class="font-headline-md uppercase m-0 leading-none">CRITICAL_WARNING</h2>
            </div>
            <div class="p-8">
                <p class="font-body-lg mb-8 uppercase text-on-background">
                    YOU ARE ABOUT TO PERMANENTLY DELETE THIS RECORD FROM THE DATABASE. THIS ACTION CANNOT BE UNDONE.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <button type="button" onclick="closeDeleteModal()" class="px-6 py-3 font-label-bold uppercase bg-surface-variant text-on-background border-border-width border-on-background hover:bg-surface-container-highest transition-colors shadow-[4px_4px_0px_0px_#1a1c1c] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none">
                        [ ABORT ]
                    </button>
                    <form id="delete-form" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-6 py-3 font-label-bold uppercase bg-error text-on-error border-border-width border-on-background hover:opacity-90 transition-opacity shadow-[4px_4px_0px_0px_#1a1c1c] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none">
                            [ CONFIRM_DELETE ]
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(url) {
            const modal = document.getElementById('delete-modal');
            const content = modal.querySelector('.modal-content');
            document.getElementById('delete-form').action = url;
            
            modal.classList.remove('hidden');
            // Trigger animation
            setTimeout(() => {
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
        }
        function closeDeleteModal() {
            const modal = document.getElementById('delete-modal');
            const content = modal.querySelector('.modal-content');
            
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.getElementById('delete-form').action = '';
            }, 200); // Wait for transition
        }
    </script>

</body>
</html>
