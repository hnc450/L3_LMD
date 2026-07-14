<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>@yield('title')</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @endif
</head>
<body class="bg-slate-50 text-gray-900 min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')
        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between lg:hidden">
                <a href="{{ route('index') }}" class="font-bold text-blue-700">Plateforme</a>
                <form method="POST" action="{{ route('auth.logout') }}">@csrf @method('DELETE')
                    <button class="text-red-600 text-sm">Déconnexion</button>
                </form>
            </header>
            <main class="flex-1 p-6 overflow-auto">
                @include('layouts.alerts')
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
