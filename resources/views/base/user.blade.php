<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-gray-900 min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')
        <div class="flex-1 flex flex-col min-w-0">
            <main class="flex-1 p-6 overflow-auto">
                @include('layouts.alerts')
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
