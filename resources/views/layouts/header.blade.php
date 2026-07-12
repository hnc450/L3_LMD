<header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm">
    <nav class="container mx-auto px-6">
        <div class="flex items-center justify-between h-20">
            <a href="{{ route('index') }}" class="flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-blue-700 to-cyan-500 flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-landmark text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-blue-700 transition">Plateforme</h2>
                    <p class="text-sm text-gray-500">Gestion des plaintes</p>
                </div>
            </a>

            <ul class="hidden lg:flex items-center gap-8 font-medium">
                <li><a href="{{ route('index') }}" class="text-gray-700 hover:text-blue-700 transition">Accueil</a></li>
                <li><a href="{{ route('services') }}" class="text-gray-700 hover:text-blue-700 transition">Services</a></li>
                <li><a href="{{ route('complaints.create') }}" class="text-gray-700 hover:text-blue-700 transition">Déposer une plainte</a></li>
                <li><a href="{{ route('public.track.form') }}" class="text-gray-700 hover:text-blue-700 transition">Suivi</a></li>
            </ul>

            <div class="flex items-center gap-4">
                @guest
                    <a href="{{ route('auth.login') }}" class="text-gray-700 hover:text-blue-700 font-medium">Connexion</a>
                    <a href="{{ route('auth.register') }}" class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-700 to-cyan-500 text-white font-semibold shadow-lg hover:scale-105 transition">
                        Inscription
                    </a>
                @endguest
                @auth
                    <a href="{{ route(auth()->user()->dashboardRoute()) }}" class="px-5 py-3 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">
                        Mon espace
                    </a>
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf @method('DELETE')
                        <button class="px-5 py-3 rounded-xl bg-red-50 text-red-600 font-semibold hover:bg-red-100 transition">Déconnexion</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>
</header>
