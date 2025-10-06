<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Connexion - Administration</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full">
        <!-- Logo et titre -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="h-12 w-12 bg-gray-900 rounded-lg flex items-center justify-center">
                    <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl font-light text-gray-900 tracking-tight">Administration</h1>
            <p class="mt-2 text-gray-600 font-light">Musée des Civilisations Noires</p>
        </div>

        <!-- Formulaire de connexion -->
        <div class="bg-white shadow-sm border border-gray-200 p-8">
            <h2 class="text-xl font-light text-gray-900 tracking-wide mb-6 text-center">Connexion</h2>

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <div class="text-sm font-light text-red-800">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-light text-gray-700 tracking-wide mb-2">ADRESSE EMAIL</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-3 py-3 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light text-lg">
                </div>

                <div>
                    <label for="password" class="block text-sm font-light text-gray-700 tracking-wide mb-2">MOT DE PASSE</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-3 py-3 border border-gray-300 focus:ring-gray-500 focus:border-gray-500 font-light text-lg">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                           class="h-4 w-4 text-gray-600 border-gray-300 rounded focus:ring-gray-500">
                    <label for="remember" class="ml-2 text-sm font-light text-gray-700 tracking-wide">Se souvenir de moi</label>
                </div>

                <div>
                    <button type="submit" class="w-full py-3 bg-gray-900 text-white text-sm font-light tracking-wide hover:bg-gray-800 transition-colors duration-200">
                        SE CONNECTER
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-900 font-light tracking-wide transition-colors duration-200">
                    ← Retour au site
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500 font-light">
                &copy; {{ date('Y') }} Musée des Civilisations Noires
            </p>
        </div>
    </div>
</body>
</html>