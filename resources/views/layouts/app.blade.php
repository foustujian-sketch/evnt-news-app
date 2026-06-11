<!DOCTYPE html>
<html class="light scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="overflow-x: hidden;">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '>_EVNT | Global Tech Events & Hackathons')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' fill='%231a1c1c'/%3E%3Ctext y='70' x='15' fill='%2339ff14' font-family='monospace' font-size='60' font-weight='bold'%3E%3E_%3C/text%3E%3C/svg%3E">

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Discover the best global tech events, coding hackathons, developer conferences, open source summits, and startup networking opportunities worldwide.')">
    <meta name="keywords" content="Tech Events, Hackathons, Developer Conferences, Tech News, Programming Workshops">
    <meta name="author" content=">_EVNT Platform">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', '>_EVNT | Global Tech Events & Hackathons')">
    <meta property="og:description" content="@yield('meta_description', 'Discover the best global tech events, coding hackathons, developer conferences, open source summits, and startup networking opportunities worldwide.')">
    <meta property="og:image" content="@yield('meta_image', 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=1200&h=630')">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', '>_EVNT | Global Tech Events & Hackathons')">
    <meta property="twitter:description" content="@yield('meta_description', 'Discover the best global tech events, coding hackathons, developer conferences, open source summits, and startup networking opportunities worldwide.')">
    <meta property="twitter:image" content="@yield('meta_image', 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=1200&h=630')">

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
                    "tertiary-fixed": "#e2e2e2",
                    "on-secondary-fixed": "#1f1c00",
                    "primary-fixed-dim": "#2ae500",
                    "error-container": "#ffdad6",
                    "on-tertiary-container": "#616161",
                    "surface-container-lowest": "#ffffff",
                    "inverse-on-surface": "#f0f1f1",
                    "primary": "#106e00",
                    "on-tertiary-fixed-variant": "#474747",
                    "background": "#f9f9f9",
                    "on-primary-fixed": "#022100",
                    "tertiary-fixed-dim": "#c6c6c6",
                    "outline-variant": "#baccb0",
                    "tertiary-container": "#dddddd",
                    "tertiary": "#5e5e5e",
                    "on-primary-fixed-variant": "#095300",
                    "surface-container-highest": "#e2e2e2",
                    "inverse-primary": "#2ae500",
                    "secondary": "#676000",
                    "primary-container": "#39ff14",
                    "secondary-container": "#f3e300",
                    "on-primary-container": "#107100",
                    "outline": "#6b7c63",
                    "on-surface": "#1a1c1c",
                    "on-secondary-fixed-variant": "#4d4800",
                    "surface-tint": "#106e00",
                    "secondary-fixed": "#f6e600",
                    "on-tertiary-fixed": "#1b1b1b",
                    "primary-fixed": "#79ff5b",
                    "on-surface-variant": "#3c4b35",
                    "surface-container-high": "#e8e8e8",
                    "on-secondary-container": "#6b6400",
                    "inverse-surface": "#2f3131",
                    "surface-variant": "#e2e2e2",
                    "surface": "#f9f9f9",
                    "on-background": "#1a1c1c",
                    "on-error": "#ffffff",
                    "on-tertiary": "#ffffff",
                    "on-secondary": "#ffffff",
                    "on-primary": "#ffffff",
                    "error": "#ba1a1a",
                    "surface-dim": "#dadada",
                    "surface-container-low": "#f3f3f4",
                    "secondary-fixed-dim": "#d7ca00",
                    "surface-bright": "#f9f9f9",
                    "on-error-container": "#93000a"
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
        .brutal-btn {
            transition: transform 0.1s ease;
        }
        .brutal-btn:active {
            transform: translate(4px, 4px);
            box-shadow: 0px 0px 0px 0px rgba(0,0,0,1) !important;
        }
        .brutal-btn:hover {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px 0px rgba(0,0,0,1);
        }
        .brutal-input:focus {
            outline: 4px solid #1a1c1c;
            outline-offset: -4px;
            box-shadow: 4px 4px 0px 0px #39ff14;
        }
        /* Override Chrome Autofill styling */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active{
            -webkit-box-shadow: 0 0 0 30px #ffffff inset !important;
            -webkit-text-fill-color: #1a1c1c !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        .brutal-shadow-black {
            box-shadow: 8px 8px 0px 0px #000000;
        }
        .brutal-shadow-primary {
            box-shadow: 8px 8px 0px 0px #39ff14;
        }
        .brutal-shadow-secondary {
            box-shadow: 8px 8px 0px 0px #f6e600;
        }
        .brutal-border {
            border: 4px solid #1a1c1c;
        }
        .terminal-bullet::before {
            content: "";
            display: inline-block;
            width: 12px;
            height: 12px;
            background-color: #39ff14;
            margin-right: 8px;
            vertical-align: middle;
        }
        .terminal-cursor {
            display: inline-block;
            width: 12px;
            height: 20px;
            background-color: #39ff14;
            vertical-align: middle;
            margin-left: 4px;
            animation: pulse 1s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: .5; }
        }
        
        @keyframes marqueeLeft {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            animation: marqueeLeft 40s linear infinite;
        }
        
        @keyframes slideLeft {
            0% { background-position: 0px 0px; }
            100% { background-position: -40px 0px; }
        }
        .animate-grid-left {
            animation: slideLeft 1s linear infinite;
        }
        
        /* Required for auth scaffolding overrides */
        .brutal-shadow-black {
            box-shadow: 8px 8px 0px 0px #000000;
        }
        
        body {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body class="text-on-surface font-body-md min-h-screen flex flex-col selection:bg-primary-container selection:text-on-primary-container">

    @include('components.navbar')

    <main class="flex-grow w-full max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-8 md:py-12">
        @yield('content')
        
        <!-- Slot integration for Breeze compatibility -->
        @if (isset($slot))
            {{ $slot }}
        @endif
    </main>

    @include('components.footer')

</body>
</html>
