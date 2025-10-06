<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('app.title') }} - @yield('title', __('app.home'))</title>

    <meta name="description" content="@yield('description', __('app.footer_description'))" @vite(['resources/css/app.css', 'resources/js/app.js']) @livewireStyles </head>

<body class="bg-gray-50 min-h-screen">
    <nav class="top-0 z-50 sticky bg-white/95 shadow-sm backdrop-blur-sm border-gray-200 border-b">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex justify-center items-center bg-green-600 rounded-lg w-8 h-8">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="font-light text-gray-900 text-lg tracking-wide">
                                {{ __('Musée des Civilisations Noires') }}</div>
                        </div>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('gallery') }}"
                        class="px-3 py-2 font-light text-gray-700 hover:text-gray-900 text-sm tracking-wide transition-colors duration-200">
                        {{ __('app.gallery') }}
                    </a>

                    <a href="{{ route('qr.gallery') }}"
                        class="px-3 py-2 font-light text-gray-700 hover:text-gray-900 text-sm tracking-wide transition-colors duration-200">
                        QR CODES
                    </a>

                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="px-3 py-2 font-light text-gray-700 hover:text-gray-900 text-sm tracking-wide transition-colors duration-200">
                            ADMIN
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-3 py-2 font-light text-gray-700 hover:text-gray-900 text-sm tracking-wide transition-colors duration-200">
                            CONNEXION
                        </a>
                    @endauth

                    <div class="flex items-center space-x-2">
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="flex items-center px-3 py-2 font-light text-gray-700 hover:text-gray-900 text-sm tracking-wide transition-colors duration-200">
                                <svg class="mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                                </svg>
                                {{ __('app.language') }}
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                class="right-0 z-50 absolute bg-white shadow-lg mt-2 py-1 rounded-md w-48">
                                <a href="?lang=fr" class="block hover:bg-gray-100 px-4 py-2 text-gray-700 text-sm">🇫🇷
                                    Français</a>
                                <a href="?lang=en" class="block hover:bg-gray-100 px-4 py-2 text-gray-700 text-sm">🇬🇧
                                    English</a>
                                <a href="?lang=wo" class="block hover:bg-gray-100 px-4 py-2 text-gray-700 text-sm">🇸🇳
                                    Wolof</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white mt-16 border-gray-200 border-t">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 py-12 max-w-7xl">
            <div class="gap-8 grid grid-cols-1 md:grid-cols-3">
                <div>
                    <div class="flex items-center">
                        <div class="flex justify-center items-center bg-green-600 rounded-lg w-8 h-8">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="ml-2 font-light text-gray-900 text-lg tracking-wide">Musée des Civilisations
                            Noires</span>
                    </div>
                    <p class="mt-2 font-light text-gray-600 leading-relaxed">
                        Démocratiser l'accès aux contenus culturels via le digital et faire rayonner notre patrimoine
                        au-delà des murs du musée.
                    </p>
                </div>

                <div>
                    <h3 class="font-light text-gray-900 text-sm uppercase tracking-widest">NAVIGATION</h3>
                    <ul class="space-y-4 mt-4">
                        <li><a href="{{ route('gallery') }}"
                                class="font-light text-gray-600 hover:text-gray-900 transition-colors duration-200">Galerie</a>
                        </li>
                        <li><a href="#"
                                class="font-light text-gray-600 hover:text-gray-900 transition-colors duration-200">À
                                propos</a></li>
                        <li><a href="#"
                                class="font-light text-gray-600 hover:text-gray-900 transition-colors duration-200">Contact</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-light text-gray-900 text-sm uppercase tracking-widest">FONCTIONNALITÉS</h3>
                    <ul class="space-y-4 mt-4">
                        <li class="flex items-center font-light text-gray-600">
                            <svg class="mr-3 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                            Scan QR Code
                        </li>
                        <li class="flex items-center font-light text-gray-600">
                            <svg class="mr-3 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 14.142M8.586 17.414A2 2 0 118.586 6.586l8.828 8.828-2.828 2.828a2 2 0 01-2.828 0l-8.828-8.828z" />
                            </svg>
                            Audio Guide
                        </li>
                        <li class="flex items-center font-light text-gray-600">
                            <svg class="mr-3 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                            </svg>
                            Multilingue
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-8 border-gray-200 border-t">
                <p class="font-light text-gray-400 text-sm text-center tracking-wide">
                    &copy; {{ date('Y') }} <a href="https://github.com/weexduunx" target="_blank"
                        rel="noopener noreferrer" class="hover:underline">Idrissa Ndiouck </a> - Musée des
                    Civilisations Noires TOUS
                    DROITS RÉSERVÉS.
                </p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>

</html>
