<!DOCTYPE html>
<html lang="en" class="{{ auth()->check() && in_array(Route::currentRouteName(), ['peserta.dashboard', 'peserta.catalog.index', 'peserta.catalog.show', 'peserta.learning.index', 'peserta.orders.index', 'peserta.profile.edit', 'peserta.pricing', 'peserta.checkout', 'peserta.learning.course', 'peserta.learning.material']) ? 'premium-theme' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WIB - Waktu Informatika Belajar')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        /* Page Transition - Smooth fade without black flash */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        body {
            animation: fadeIn 0.3s ease-in-out;
        }

        /* Premium Cyan Theme - Applied to ALL users */
        .premium-theme body {
            background-color: #00BCD4 !important;
            transition: background-color 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .premium-theme nav {
            background-color: #00ACC1 !important;
            border-bottom-color: #0097A7 !important;
        }

        .premium-theme .bg-white {
            background-color: #E0F7FA !important;
        }

        /* Keep form inputs WHITE even with premium theme */
        .premium-theme input.bg-white,
        .premium-theme input,
        .premium-theme textarea,
        .premium-theme select {
            background-color: white !important;
        }

        .premium-theme .text-black {
            color: #006064 !important;
        }

        .premium-theme .text-gray-600 {
            color: #00838F !important;
        }

        .premium-theme .border-gray-200,
        .premium-theme .border-gray-300 {
            border-color: #0097A7 !important;
        }

        /* Animated text effects */
        @keyframes textGlitch {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(-2px, 1px); }
            40% { transform: translate(1px, -1px); }
            60% { transform: translate(-1px, 2px); }
            80% { transform: translate(2px, -2px); }
        }

        .text-animate {
            display: inline-block;
            animation: textGlitch 0.3s ease-in-out;
        }

        h1, h2, h3 {
            transition: all 0.3s ease;
        }

        h1:hover .char, h2:hover .char, h3:hover .char {
            animation: textGlitch 0.5s ease-in-out infinite;
        }

        /* Preloader Styles */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #000000;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            transition: opacity 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #preloader.fade-out {
            opacity: 0;
        }

        /* Smooth page transition */
        .page-transition {
            animation: pageSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes pageSlideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .preloader-logo-img {
            width: 180px;
            height: auto;
            opacity: 0;
            transform: scale(0.9);
            animation: logoFadeIn 1.2s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            margin-bottom: 1rem;
        }

        @keyframes logoFadeIn {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }


        .preloader-logo-text {
            font-size: 7rem;
            font-weight: 900;
            color: transparent;
            -webkit-text-stroke: 2px #ffffff;
            text-stroke: 2px #ffffff;
            letter-spacing: 0.2em;
            opacity: 0;
            transform: scale(0.9);
            animation: logoFadeIn 1.2s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            margin-bottom: 3rem;
            font-family: 'Playfair Display', serif;
        }

        @keyframes textFadeIn {
            to {
                opacity: 1;
            }
        }

        .welcome-text {
            font-size: 1.25rem;
            font-weight: 300;
            color: #ffffff;
            letter-spacing: 0.05em;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            opacity: 0;
            animation: textFadeIn 1s cubic-bezier(0.4, 0, 0.2, 1) 1.2s forwards;
            position: relative;
            padding: 0.5rem;
            z-index: 20;
        }

        .text-content {
            position: relative;
            z-index: 20;
        }

        /* Matrix Rain Animation */
        #matrix-rain {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10;
            pointer-events: none;
        }

        .matrix-column {
            position: absolute;
            top: -100%;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 0 0 8px rgba(255, 255, 255, 0.6), 0 0 12px rgba(255, 255, 255, 0.3);
            white-space: pre;
            line-height: 1.2;
            animation: matrixFall linear forwards, glitchFlicker 0.15s infinite;
        }

        @keyframes glitchFlicker {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.85; }
        }

        @keyframes matrixFall {
            to {
                top: 100%;
            }
        }

        /* Smooth Reveal Animations */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .reveal-on-scroll.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Magnetic Button Base */
        .btn-magnetic, .magnetic-btn {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* Enhanced hover effects */
        button, a {
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
    </style>
</head>
<body class="bg-white transition-colors duration-200 overflow-hidden" id="app-body">
    <!-- Preloader -->
    <div id="preloader">
        <!-- Matrix Rain Effect -->
        <div id="matrix-rain"></div>

        <!-- Logo Image -->
        <img src="{{ asset('images/logomedia.png') }}" class="preloader-logo-img" alt="W.I.B">

        <div class="welcome-text">
            <span class="text-content">Waktu Informatika Belajar</span>
        </div>
    </div>
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-gray-200 transition-colors duration-300 z-50" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
            <div class="flex justify-between h-full">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-xl font-light text-black hover:opacity-70 transition-opacity">
                            W. I. B
                        </a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        @yield('nav-links')
                    </div>

                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = true" type="button" class="sm:hidden ml-4 inline-flex items-center justify-center p-2 text-gray-600 hover:text-black hover:bg-gray-100 focus:outline-none transition-colors" aria-label="Open menu">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
                <div class="flex items-center space-x-6">
                    @auth
                        @php
                                $style = auth()->user()->border_style;
                                $styleClasses = 'bg-black text-white border-2 border-black';
                                $hasDecoration = false;

                                $decorationMap = [
                                    'space-orbit' => 'space-orbit.svg',
                                    'space-nebula' => 'space-nebula.svg',
                                    'space-constellation' => 'space-constellation.svg',
                                    'nature-vines' => 'nature-vines.svg',
                                    'nature-floral' => 'nature-floral.svg',
                                    'nature-sunburst' => 'nature-sunburst.svg',
                                    'water-bubbles' => 'water-bubbles.svg',
                                    'water-waves' => 'water-waves.svg',
                                    'water-whirlpool' => 'water-whirlpool.svg',
                                ];

                                if ($style === 'solid') {
                                    $styleClasses = 'bg-black text-white border-4 border-white';
                                } elseif ($style === 'dashed') {
                                    $styleClasses = 'bg-black text-white border-4 border-dashed border-white';
                                } elseif ($style === 'double') {
                                    $styleClasses = 'bg-black text-white border-[6px] border-double border-white';
                                } elseif (isset($decorationMap[$style]) && auth()->user()->tier === 'sangar') {
                                    $hasDecoration = true;
                                    $styleClasses = 'bg-black text-white';
                                }

                                $profileUrl = auth()->user()->role === 'admin' ? route('admin.profile.edit') : (auth()->user()->role === 'pengajar' ? route('pengajar.profile.edit') : route('peserta.profile.edit'));
                                @endphp

                                <!-- Mobile: Direct link to profile -->
                                <a href="{{ $profileUrl }}" class="sm:hidden flex items-center space-x-3 hover:opacity-70 transition-opacity">
                                    <div class="relative inline-block w-8 h-8">
                                        @if($hasDecoration)
                                        <!-- SVG Decoration Layer -->
                                        <div class="absolute pointer-events-none" style="top: -15%; left: -15%; width: 130%; height: 130%; z-index: 0;">
                                            @if($style === 'space-orbit')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><circle cx="60" cy="60" r="52" stroke="#6366f1" stroke-width="1.5" stroke-dasharray="4 4" /><circle cx="10" cy="40" r="6" fill="#8b5cf6" /><circle cx="110" cy="80" r="4" fill="#a78bfa" /><circle cx="70" cy="8" r="3" fill="#e2e8f0" /></svg>
                                            @elseif($style === 'space-nebula')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><defs><linearGradient id="nebula-mobile" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#ec4899" /><stop offset="50%" stop-color="#8b5cf6" /><stop offset="100%" stop-color="#3b82f6" /></linearGradient><filter id="glow-mobile" x="-20%" y="-20%" width="140%" height="140%"><feGaussianBlur stdDeviation="3" result="blur" /><feComposite in="SourceGraphic" in2="blur" operator="over" /></filter></defs><circle cx="60" cy="60" r="53" stroke="url(#nebula-mobile)" stroke-width="4" filter="url(#glow-mobile)" /></svg>
                                            @elseif($style === 'space-constellation')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><circle cx="60" cy="60" r="50" stroke="#1e293b" stroke-width="2" /><polyline points="20,20 40,10 70,15 100,30" stroke="#fde047" stroke-width="1.5" fill="none" /><circle cx="20" cy="20" r="2.5" fill="#fef08a" /><circle cx="40" cy="10" r="2" fill="#fef08a" /><circle cx="70" cy="15" r="3" fill="#fef08a" /><circle cx="100" cy="30" r="2" fill="#fef08a" /></svg>
                                            @elseif($style === 'nature-vines')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><circle cx="60" cy="60" r="51" stroke="#22c55e" stroke-width="3" /><path d="M 12 50 Q 0 40 10 30" stroke="#16a34a" stroke-width="2" fill="none" stroke-linecap="round" /><ellipse cx="10" cy="30" rx="4" ry="7" transform="rotate(45 10 30)" fill="#4ade80" /></svg>
                                            @elseif($style === 'nature-floral')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><circle cx="60" cy="60" r="50" stroke="#fbcfe8" stroke-width="2" /><circle cx="20" cy="20" r="8" fill="#f472b6" /><circle cx="15" cy="28" r="6" fill="#f9a8d4" /><circle cx="28" cy="15" r="6" fill="#f9a8d4" /></svg>
                                            @elseif($style === 'nature-sunburst')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><circle cx="60" cy="60" r="48" stroke="#fbbf24" stroke-width="2" /><path d="M 60 5 L 60 12" stroke="#fbbf24" stroke-width="3" stroke-linecap="round" /><path d="M 60 115 L 60 108" stroke="#fbbf24" stroke-width="3" stroke-linecap="round" /></svg>
                                            @elseif($style === 'water-bubbles')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><circle cx="60" cy="60" r="50" stroke="#38bdf8" stroke-width="1.5" /><circle cx="15" cy="80" r="10" fill="#7dd3fc" fill-opacity="0.8" /><circle cx="105" cy="30" r="8" fill="#7dd3fc" fill-opacity="0.8" /></svg>
                                            @elseif($style === 'water-waves')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><path d="M 10 60 C 10 20, 50 10, 80 15 C 110 20, 110 80, 80 105 C 50 130, 10 100, 10 60 Z" stroke="#0ea5e9" stroke-width="3" fill="none" /></svg>
                                            @elseif($style === 'water-whirlpool')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><path d="M 60 10 A 50 50 0 0 1 110 60" stroke="#0284c7" stroke-width="4" stroke-linecap="round" fill="none" /><path d="M 110 60 A 50 50 0 0 1 60 110" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round" fill="none" /></svg>
                                            @endif
                                        </div>
                                        @endif

                                        <!-- Avatar -->
                                        @if(auth()->user()->profile_photo)
                                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" class="relative w-8 h-8 rounded-full object-cover {{ $styleClasses }}" style="z-index: 1;">
                                        @else
                                            <div class="relative w-8 h-8 rounded-full flex items-center justify-center {{ $styleClasses }}" style="z-index: 1;">
                                                <span class="text-white text-xs font-medium">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                <!-- Desktop: Dropdown button -->
                                <div class="hidden sm:block relative" x-data="{ profileDropdown: false }">
                                    <button type="button" @click="profileDropdown = !profileDropdown" @click.away="profileDropdown = false" class="flex items-center space-x-3 hover:opacity-70 transition-opacity cursor-pointer">
                                        <div class="relative inline-block w-8 h-8">
                                    @if($hasDecoration)
                                    <!-- SVG Decoration Layer -->
                                    <div class="absolute pointer-events-none" style="top: -15%; left: -15%; width: 130%; height: 130%; z-index: 0;">
                                        @if($style === 'space-orbit')
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><circle cx="60" cy="60" r="52" stroke="#6366f1" stroke-width="1.5" stroke-dasharray="4 4" /><circle cx="10" cy="40" r="6" fill="#8b5cf6" /><circle cx="110" cy="80" r="4" fill="#a78bfa" /><circle cx="70" cy="8" r="3" fill="#e2e8f0" /></svg>
                                        @elseif($style === 'space-nebula')
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><defs><linearGradient id="nebula-nav" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#ec4899" /><stop offset="50%" stop-color="#8b5cf6" /><stop offset="100%" stop-color="#3b82f6" /></linearGradient><filter id="glow-nav" x="-20%" y="-20%" width="140%" height="140%"><feGaussianBlur stdDeviation="3" result="blur" /><feComposite in="SourceGraphic" in2="blur" operator="over" /></filter></defs><circle cx="60" cy="60" r="53" stroke="url(#nebula-nav)" stroke-width="4" filter="url(#glow-nav)" /></svg>
                                        @elseif($style === 'space-constellation')
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><circle cx="60" cy="60" r="50" stroke="#1e293b" stroke-width="2" /><polyline points="20,20 40,10 70,15 100,30" stroke="#fde047" stroke-width="1.5" fill="none" /><circle cx="20" cy="20" r="2.5" fill="#fef08a" /><circle cx="40" cy="10" r="2" fill="#fef08a" /><circle cx="70" cy="15" r="3" fill="#fef08a" /><circle cx="100" cy="30" r="2" fill="#fef08a" /></svg>
                                        @elseif($style === 'nature-vines')
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><circle cx="60" cy="60" r="51" stroke="#22c55e" stroke-width="3" /><path d="M 12 50 Q 0 40 10 30" stroke="#16a34a" stroke-width="2" fill="none" stroke-linecap="round" /><ellipse cx="10" cy="30" rx="4" ry="7" transform="rotate(45 10 30)" fill="#4ade80" /></svg>
                                        @elseif($style === 'nature-floral')
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><circle cx="60" cy="60" r="50" stroke="#fbcfe8" stroke-width="2" /><circle cx="20" cy="20" r="8" fill="#f472b6" /><circle cx="15" cy="28" r="6" fill="#f9a8d4" /><circle cx="28" cy="15" r="6" fill="#f9a8d4" /></svg>
                                        @elseif($style === 'nature-sunburst')
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><circle cx="60" cy="60" r="48" stroke="#fbbf24" stroke-width="2" /><path d="M 60 5 L 60 12" stroke="#fbbf24" stroke-width="3" stroke-linecap="round" /><path d="M 60 115 L 60 108" stroke="#fbbf24" stroke-width="3" stroke-linecap="round" /></svg>
                                        @elseif($style === 'water-bubbles')
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><circle cx="60" cy="60" r="50" stroke="#38bdf8" stroke-width="1.5" /><circle cx="15" cy="80" r="10" fill="#7dd3fc" fill-opacity="0.8" /><circle cx="105" cy="30" r="8" fill="#7dd3fc" fill-opacity="0.8" /></svg>
                                        @elseif($style === 'water-waves')
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><path d="M 10 60 C 10 20, 50 10, 80 15 C 110 20, 110 80, 80 105 C 50 130, 10 100, 10 60 Z" stroke="#0ea5e9" stroke-width="3" fill="none" /></svg>
                                        @elseif($style === 'water-whirlpool')
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" fill="none" class="w-full h-full"><path d="M 60 10 A 50 50 0 0 1 110 60" stroke="#0284c7" stroke-width="4" stroke-linecap="round" fill="none" /><path d="M 110 60 A 50 50 0 0 1 60 110" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round" fill="none" /></svg>
                                        @endif
                                    </div>
                                    @endif

                                    <!-- Avatar -->
                                    @if(auth()->user()->profile_photo)
                                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" class="relative w-8 h-8 rounded-full object-cover {{ $styleClasses }}" style="z-index: 1;">
                                    @else
                                        <div class="relative w-8 h-8 rounded-full flex items-center justify-center {{ $styleClasses }}" style="z-index: 1;">
                                            <span class="text-white text-xs font-medium">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                        </div>
                                        @endif
                                    </div>

                                    <span class="text-sm font-light text-gray-900">{{ auth()->user()->name }}</span>

                                    <!-- Dropdown Arrow -->
                                    <svg class="w-4 h-4 text-gray-600" :class="{ 'rotate-180': profileDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="profileDropdown"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-white border-2 border-black shadow-lg z-50"
                                     style="display: none;">
                                    <a href="{{ $profileUrl }}"
                                       class="block px-4 py-3 text-sm font-light text-gray-900 hover:bg-gray-50 border-b border-gray-200 transition-colors">
                                        Edit Profil
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-3 text-sm font-light text-gray-900 hover:bg-gray-50 transition-colors">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-light text-gray-600 hover:text-black px-3 py-2 transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="text-sm font-light bg-black text-white px-6 py-2 hover:bg-gray-800 transition-all">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div x-show="mobileMenuOpen" @keydown.escape.window="mobileMenuOpen = false" class="sm:hidden" style="display: none;">
            <!-- Backdrop -->
            <div x-show="mobileMenuOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="mobileMenuOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>

            <!-- Slide-in Menu -->
            <div x-show="mobileMenuOpen" x-transition:enter="transform transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="fixed top-0 right-0 bottom-0 w-80 max-w-[85vw] bg-white border-l-2 border-black shadow-xl z-50 overflow-y-auto">

                <!-- Close Button -->
                <div class="flex items-center justify-between p-4 border-b-2 border-black">
                    <span class="text-lg font-light text-black">Menu</span>
                    <button @click="mobileMenuOpen = false" class="p-2 text-gray-600 hover:text-black transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Nav Links -->
                <nav class="py-4">
                    <div class="flex flex-col space-y-1">
                        @yield('mobile-nav-links')
                    </div>
                </nav>

                <!-- Logout Button at Bottom -->
                @auth
                <div class="absolute bottom-0 left-0 right-0 border-t-2 border-black bg-white">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full px-4 py-4 text-base font-light text-gray-900 hover:bg-gray-50 text-left transition-colors">
                            <svg class="inline-block h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Navbar Spacer -->
    <div class="h-24"></div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-white border border-black text-black px-4 py-3 font-light">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-black border border-black text-white px-4 py-3 font-light">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="page-transition">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-900 text-sm font-light">
                &copy; {{ date('Y') }} Waktu Informatika Belajar. All rights reserved.
            </p>
        </div>
    </footer>

    <script>
        // Text animations and effects
        document.addEventListener('DOMContentLoaded', () => {
            const headings = document.querySelectorAll('h1, h2, h3');
            headings.forEach(heading => {
                const text = heading.textContent;
                heading.innerHTML = text.split('').map(char =>
                    char === ' ' ? ' ' : `<span class="char">${char}</span>`
                ).join('');
            });

            // Scramble text effect for navbar links (locomotive.ca style)
            class TextScramble {
                constructor(el) {
                    this.el = el;
                    this.chars = '!<>-_\\/[]{}—=+*^?#________';
                    this.update = this.update.bind(this);
                }

                setText(newText) {
                    const oldText = this.el.innerText;
                    const length = Math.max(oldText.length, newText.length);
                    const promise = new Promise((resolve) => this.resolve = resolve);
                    this.queue = [];
                    for (let i = 0; i < length; i++) {
                        const from = oldText[i] || '';
                        const to = newText[i] || '';
                        const start = Math.floor(Math.random() * 40);
                        const end = start + Math.floor(Math.random() * 40);
                        this.queue.push({ from, to, start, end });
                    }
                    cancelAnimationFrame(this.frameRequest);
                    this.frame = 0;
                    this.update();
                    return promise;
                }

                update() {
                    let output = '';
                    let complete = 0;
                    for (let i = 0, n = this.queue.length; i < n; i++) {
                        let { from, to, start, end, char } = this.queue[i];
                        if (this.frame >= end) {
                            complete++;
                            output += to;
                        } else if (this.frame >= start) {
                            if (!char || Math.random() < 0.28) {
                                char = this.randomChar();
                                this.queue[i].char = char;
                            }
                            output += `<span style="opacity: 0.5">${char}</span>`;
                        } else {
                            output += from;
                        }
                    }
                    this.el.innerHTML = output;
                    if (complete === this.queue.length) {
                        this.resolve();
                    } else {
                        this.frameRequest = requestAnimationFrame(this.update);
                        this.frame++;
                    }
                }

                randomChar() {
                    return this.chars[Math.floor(Math.random() * this.chars.length)];
                }
            }

            // Apply scramble effect to navbar links
            const navLinks = document.querySelectorAll('nav a, nav button[type="submit"]');
            navLinks.forEach(link => {
                const originalText = link.innerText || link.textContent;
                if (!originalText.trim()) return;

                const fx = new TextScramble(link);

                link.addEventListener('mouseenter', () => {
                    // Fix width to prevent neighboring elements from shaking
                    // Don't change display to avoid breaking flex layout
                    const width = link.offsetWidth;
                    link.style.width = width + 'px';
                    link.style.flexShrink = '0';
                    fx.setText(originalText);
                });

                link.addEventListener('mouseleave', () => {
                    // Restore original styling after animation
                    link.style.width = '';
                    link.style.flexShrink = '';
                });
            });
        });
    </script>
</body>
</html>
