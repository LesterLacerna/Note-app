<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- PWA -->
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#0f172a">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            let deferredPrompt = null;
            let installBtn = null;

            window.addEventListener('beforeinstallprompt', (e) => {
                console.log('✓ beforeinstallprompt event fired!', e);
                e.preventDefault();
                deferredPrompt = e;
                if (installBtn) {
                    installBtn.style.display = 'inline-flex';
                }
            });

            window.addEventListener('DOMContentLoaded', () => {
                installBtn = document.getElementById('installBtn');
                console.log('PWA install script loaded', {hasBtn: !!installBtn});
                if (!installBtn) {
                    return console.warn('✗ installBtn element not found in DOM');
                }

                const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;
                if (!isStandalone) {
                    installBtn.style.display = 'inline-flex';
                }

                installBtn.addEventListener('click', async () => {
                    console.log('Install button clicked', {deferredPrompt: !!deferredPrompt});
                    if (deferredPrompt) {
                        deferredPrompt.prompt();
                        const result = await deferredPrompt.userChoice;
                        if (result.outcome === 'accepted') {
                            console.log('User accepted install');
                            installBtn.style.display = 'none';
                        }
                        deferredPrompt = null;
                        return;
                    }

                    if (/iphone|ipad|ipod/i.test(navigator.userAgent)) {
                        alert('Use Safari share menu and choose "Add to Home Screen" to install this app.');
                        return;
                    }

                    alert('Install prompt is not available on this browser. Use the browser menu to add to home screen.');
                });
            });
        </script>
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-100">
        <div {{ $attributes->merge(['class' => 'min-h-screen bg-slate-950']) }}>
            @include('layouts.navigation')

            <!-- PWA Install Button (hidden until available) -->
            <div class="fixed bottom-6 right-6 z-[9999]">
                <button id="installBtn" type="button" class="hidden inline-flex items-center gap-2 bg-white hover:bg-slate-100 text-slate-950 px-4 py-2 rounded-full text-sm font-medium shadow-lg border border-slate-200 pointer-events-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V3"/>
                    </svg>
                    Install App
                </button>
            </div>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-slate-900 shadow shadow-slate-800">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js');
        }

        window.addEventListener('load', () => {
            if (navigator.onLine) console.log('App is online');
            if ('serviceWorker' in navigator) console.log('Service Worker API available');
        });
        </script>
    </body>
</html>
