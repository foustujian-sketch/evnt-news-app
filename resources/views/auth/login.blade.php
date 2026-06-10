@extends('layouts.app')

@section('title', ' | LOGIN_REQUIRED')

@section('content')

<!-- Interactive Canvas Background -->
<canvas id="interactive-canvas" class="fixed top-0 left-0 w-full h-full -z-10 bg-surface-container-lowest"></canvas>
<script>
    const canvas = document.getElementById('interactive-canvas');
    const ctx = canvas.getContext('2d');
    
    let width, height;
    let mouse = { x: -1000, y: -1000 };
    const spacing = 40;
    
    function resize() {
        width = window.innerWidth;
        height = window.innerHeight;
        canvas.width = width;
        canvas.height = height;
    }
    
    window.addEventListener('resize', resize);
    resize();
    
    document.addEventListener('mousemove', e => {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    });
    
    function draw() {
        ctx.clearRect(0, 0, width, height);
        
        const cols = Math.ceil(width / spacing);
        const rows = Math.ceil(height / spacing);
        
        for (let i = 0; i <= cols; i++) {
            for (let j = 0; j <= rows; j++) {
                let x = i * spacing;
                let y = j * spacing;
                
                let dx = mouse.x - x;
                let dy = mouse.y - y;
                let dist = Math.sqrt(dx * dx + dy * dy);
                
                let maxDist = 300;
                let size = 2; // Base dot size
                let length = size;
                let angle = 0;
                
                if (dist < maxDist) {
                    let factor = Math.pow(1 - (dist / maxDist), 2); // Exponential curve for smoother effect
                    length = size + (factor * 20); // Stretch up to 20px
                    angle = Math.atan2(dy, dx);
                }
                
                ctx.save();
                ctx.translate(x, y);
                ctx.rotate(angle);
                
                ctx.fillStyle = '#39ff14';
                // Draw a rounded rectangle/line
                ctx.beginPath();
                ctx.roundRect(-length/2, -size/2, length, size, size/2);
                ctx.fill();
                
                ctx.restore();
            }
        }
        requestAnimationFrame(draw);
    }
    
    draw();
</script>

<div class="flex items-center justify-center min-h-[60vh]">
    <div class="w-full max-w-md bg-surface border-border-width border-on-background shadow-block-black p-8">
        <h1 class="font-headline-md text-headline-md uppercase mb-4 mt-4 leading-tight flex items-center">
            INIT_LOGIN<span class="terminal-cursor"></span>
        </h1>
        <p class="font-label-mono text-label-mono text-tertiary mb-10 mt-2 tracking-wide">AUTHENTICATION_REQUIRED // PLEASE_IDENTIFY</p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 font-label-bold text-primary-container bg-on-background p-2 border-border-width border-on-background text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <div class="flex flex-col gap-2">
                <label class="font-label-mono text-label-mono uppercase text-on-surface-variant flex items-center gap-2" for="email">
                    <span class="w-3 h-3 bg-on-background inline-block"></span>
                    EMAIL_ADDRESS
                </label>
                <input id="email" class="brutal-input w-full bg-surface-container-lowest border-border-width border-on-background p-4 font-body-lg text-body-lg text-on-surface focus:ring-0 transition-shadow" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                @error('email')
                    <span class="text-error font-label-mono text-sm mt-1 uppercase">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-2">
                <label class="font-label-mono text-label-mono uppercase text-on-surface-variant flex items-center gap-2" for="password">
                    <span class="w-3 h-3 bg-on-background inline-block"></span>
                    ACCESS_KEY (PASSWORD)
                </label>
                <input id="password" class="brutal-input w-full bg-surface-container-lowest border-border-width border-on-background p-4 font-body-lg text-body-lg text-on-surface focus:ring-0 transition-shadow" type="password" name="password" required autocomplete="current-password" />
                @error('password')
                    <span class="text-error font-label-mono text-sm mt-1 uppercase">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="block mt-2">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="rounded-none border-border-width border-on-background text-primary-container focus:ring-0 focus:ring-offset-0 w-6 h-6" name="remember">
                    <span class="ml-3 font-label-mono text-label-mono uppercase">PERSIST_SESSION</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex flex-col md:flex-row items-center justify-between mt-4 gap-4">
                @if (Route::has('password.request'))
                    <a class="font-label-mono text-label-mono underline decoration-4 hover:text-primary-container transition-colors uppercase" href="{{ route('password.request') }}">
                        FORGOT_ACCESS_KEY?
                    </a>
                @endif

                <button class="brutal-btn w-full md:w-auto bg-primary-container text-on-background border-border-width border-on-background shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] font-label-bold text-label-bold uppercase py-4 px-8 flex items-center justify-center gap-2" type="submit">
                    EXECUTE_LOGIN
                    <span class="material-symbols-outlined text-sm">login</span>
                </button>
            </div>
        </form>
        
        <div class="mt-8 pt-4 border-t-4 border-on-background text-center">
            <p class="font-label-mono text-label-mono uppercase">
                NO_ACCOUNT? 
                <a href="{{ route('register') }}" class="font-label-bold text-primary hover:underline decoration-4">_REGISTER_NEW_USER</a>
            </p>
        </div>
    </div>
</div>
@endsection
