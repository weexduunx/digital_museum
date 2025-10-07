<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('app.title') }} - @yield('title', __('app.home'))</title>

    <meta name="description" content="@yield('description', __('app.footer_description'))">

    <!-- PWA Meta Tags -->
    @laravelPWA

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-50 min-h-screen" x-data="{ mobileMenuOpen: false, qrDrawerOpen: false, selectedArtwork: null }">
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
                            <div class="font-light text-gray-900 text-lg tracking-wide hidden sm:block">
                                {{ __('Musée des Civilisations Noires') }}</div>
                            <div class="font-light text-gray-900 text-sm tracking-wide sm:hidden">
                                {{ __('Musée MCN') }}</div>
                        </div>
                    </a>
                </div>

                <div class="flex items-center space-x-2">
                    <!-- Menu desktop -->
                    <div class="hidden md:flex items-center space-x-4">
                        {{-- <a href="{{ route('gallery') }}"
                            class="px-3 py-2 font-light text-gray-700 hover:text-gray-900 text-sm tracking-wide transition-colors duration-200">
                            {{ __('app.gallery') }}
                        </a> --}}

                        <a href="{{ route('virtual.tour') }}"
                            class="px-3 py-2 font-light text-gray-700 hover:text-gray-900 text-sm tracking-wide transition-colors duration-200">
                            VISITE 3D
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

                        <!-- Language selector for desktop -->
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

                    <!-- Bouton menu mobile -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="md:hidden p-2 text-gray-700 hover:text-gray-900 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Overlay pour le menu mobile -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="md:hidden fixed inset-0 z-40 bg-black bg-opacity-25"
         @click="mobileMenuOpen = false">
    </div>

    <!-- Drawer menu mobile -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transform transition ease-in-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="md:hidden fixed top-0 right-0 z-50 w-80 h-full bg-white shadow-xl overflow-y-auto"
         @click.away="mobileMenuOpen = false">

        <div class="px-4 py-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-medium text-gray-900">Menu</h2>
                <button @click="mobileMenuOpen = false"
                        class="p-2 text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <nav class="space-y-3">
                <a href="{{ route('home') }}"
                    class="flex items-center px-3 py-3 text-base font-light text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors"
                    @click="mobileMenuOpen = false">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Accueil
                </a>

                <a href="{{ route('gallery') }}"
                    class="flex items-center px-3 py-3 text-base font-light text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors"
                    @click="mobileMenuOpen = false">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ __('app.gallery') }}
                </a>

                <a href="{{ route('virtual.tour') }}"
                    class="flex items-center px-3 py-3 text-base font-light text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors"
                    @click="mobileMenuOpen = false">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                    </svg>
                    Visite Virtuelle 3D
                </a>

                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-3 py-3 text-base font-light text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors"
                        @click="mobileMenuOpen = false">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Administration
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="flex items-center px-3 py-3 text-base font-light text-gray-700 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors"
                        @click="mobileMenuOpen = false">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Connexion
                    </a>
                @endauth
            </nav>

            <!-- Section langue dans le drawer -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-sm font-medium text-gray-500 mb-3">Langue</h3>
                <div class="space-y-1">
                    <a href="?lang=fr" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md">
                        🇫🇷 Français
                    </a>
                    <a href="?lang=en" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md">
                        🇬🇧 English
                    </a>
                    <a href="?lang=wo" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-md">
                        🇸🇳 Wolof
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay pour le drawer QR -->
    <div x-show="qrDrawerOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 bg-black bg-opacity-50"
         @click="qrDrawerOpen = false">
    </div>

    <!-- Drawer QR Code -->
    <div x-show="qrDrawerOpen"
         x-transition:enter="transform transition ease-in-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed top-0 right-0 z-50 w-96 h-full bg-white shadow-2xl overflow-y-auto">

        <div class="p-6">
            <!-- En-tête du drawer -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-medium text-gray-900">Code QR</h2>
                <button @click="qrDrawerOpen = false"
                        class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenu du drawer -->
            <div x-show="selectedArtwork" class="space-y-6">
                <!-- Image de l'œuvre -->
                <div class="aspect-square overflow-hidden rounded-lg bg-gray-100">
                    <img x-show="selectedArtwork?.image"
                         :src="selectedArtwork?.image"
                         :alt="selectedArtwork?.title"
                         class="w-full h-full object-cover">
                </div>

                <!-- Informations de l'œuvre -->
                <div class="space-y-3">
                    <h3 x-text="selectedArtwork?.title" class="text-lg font-medium text-gray-900"></h3>
                    <p x-text="selectedArtwork?.artist" class="text-gray-600"></p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span x-text="selectedArtwork?.year"></span>
                        <span x-text="selectedArtwork?.category" class="px-2 py-1 bg-gray-100 rounded-md"></span>
                    </div>
                </div>

                <!-- Code QR -->
                <div class="border border-gray-200 rounded-lg p-6 text-center bg-gray-50">
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Scannez pour plus d'infos</h4>
                        <div id="qr-code-container" class="flex justify-center">
                            <!-- Le QR code sera injecté ici -->
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="text-xs text-gray-500 space-y-1">
                        <p>Scannez ce code avec votre téléphone</p>
                        <p>pour accéder aux détails de l'œuvre</p>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex space-x-3 pt-4 border-t border-gray-200">
                    <a :href="selectedArtwork?.detailUrl"
                       class="flex-1 bg-gray-900 text-white text-center py-3 px-4 rounded-md hover:bg-gray-800 transition-colors">
                        Voir les détails
                    </a>
                    <button @click="downloadQR()"
                            class="px-4 py-3 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

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

    <script>
        // Fonction pour ouvrir le drawer QR
        function openQRDrawer(artworkData) {
            // Utiliser Alpine pour mettre à jour les données
            document.body._x_dataStack[0].selectedArtwork = artworkData;
            document.body._x_dataStack[0].qrDrawerOpen = true;

            // Générer le QR code après un court délai
            setTimeout(() => {
                generateQRCode(artworkData.qrCode);
            }, 300);
        }

        // Fonction pour générer le QR code
        function generateQRCode(qrCodeValue) {
            const container = document.getElementById('qr-code-container');
            if (container) {
                container.innerHTML = `
                    <div class="w-32 h-32 bg-white border border-gray-300 rounded-lg flex items-center justify-center p-2">
                        <img src="/qr-code/${qrCodeValue}" alt="QR Code" class="w-full h-full object-contain">
                    </div>
                `;
            }
        }

        // Fonction pour télécharger le QR code
        function downloadQR() {
            const selectedArtwork = document.body._x_dataStack[0].selectedArtwork;
            if (selectedArtwork) {
                const link = document.createElement('a');
                link.href = `/qr-code/${selectedArtwork.qrCode}`;
                link.download = `QR_${selectedArtwork.title.replace(/[^a-z0-9]/gi, '_')}.svg`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        // Exposer les fonctions globalement
        window.openQRDrawer = openQRDrawer;
        window.downloadQR = downloadQR;
    </script>
</body>

</html>
