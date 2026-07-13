<script src="//unpkg.com/alpinejs" defer></script>

<header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm" x-data="{ open: false }">
    <nav class="container mx-auto px-6">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <a href="{{ route('index') }}" class="flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-blue-700 to-cyan-500 flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-landmark text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-blue-700 transition">Plateforme</h2>
                    <p class="text-sm text-gray-500">Gestion des plaintes</p>
                </div>
            </a>

            <!-- Menu desktop -->
            <ul class="hidden lg:flex items-center gap-8 font-medium">
                <li><a href="{{ route('index') }}" class="text-gray-700 hover:text-blue-700 transition">Accueil</a></li>
                <li><a href="{{ route('services') }}" class="text-gray-700 hover:text-blue-700 transition">Services</a></li>
                <li><a href="{{ route('complaints.create') }}" class="text-gray-700 hover:text-blue-700 transition">Déposer une plainte</a></li>
                <li><a href="{{ route('public.track.form') }}" class="text-gray-700 hover:text-blue-700 transition">Suivi</a></li>
            </ul>

            <!-- Actions desktop -->
            <div class="hidden lg:flex items-center gap-4">
                @guest
                    <a href="{{ route('auth.login') }}" class="text-gray-700 hover:text-blue-700 font-medium">Connexion</a>
                    <a href="{{ route('auth.register') }}" class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-700 to-cyan-500 text-white font-semibold shadow-lg hover:scale-105 transition">
                        Inscription
                    </a>
                @endguest
                @auth
                    <a href="{{ route('notifications.index') }}" class="relative px-5 py-3 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">
                        <i class="fa-solid fa-bell"></i>
                        @php
                            $unreadCount = \App\Models\Notification::where('id_user', auth()->id())->where('status', 'sent')->count();
                            if(auth()->user()->isResponsable()) {
                                $unreadCount += \App\Models\Rapport::where('responsable_id', auth()->id())->where('is_read', false)->count();
                            }
                        @endphp
                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route(auth()->user()->dashboardRoute()) }}" class="px-5 py-3 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">
                        Mon espace
                    </a>
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf @method('DELETE')
                        <button class="px-5 py-3 rounded-xl bg-red-50 text-red-600 font-semibold hover:bg-red-100 transition">Déconnexion</button>
                    </form>
                @endauth
            </div>

            <!-- Bouton hamburger (mobile) -->
            <button @click="open = !open" class="lg:hidden text-gray-700 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
        </div>

        <!-- Menu mobile -->
        <div x-show="open" class="lg:hidden mt-4 space-y-4">
            <a href="{{ route('index') }}" class="block text-gray-700 hover:text-blue-700">Accueil</a>
            <a href="{{ route('services') }}" class="block text-gray-700 hover:text-blue-700">Services</a>
            <a href="{{ route('complaints.create') }}" class="block text-gray-700 hover:text-blue-700">Déposer une plainte</a>
            <a href="{{ route('public.track.form') }}" class="block text-gray-700 hover:text-blue-700">Suivi</a>

            @guest
                <a href="{{ route('auth.login') }}" class="block text-gray-700 hover:text-blue-700">Connexion</a>
                <a href="{{ route('auth.register') }}" class="block px-4 py-2 rounded bg-gradient-to-r from-blue-700 to-cyan-500 text-white font-semibold">Inscription</a>
            @endguest
            @auth
                <a href="{{ route('notifications.index') }}" class="relative block px-5 py-3 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">
                    <i class="fa-solid fa-bell"></i>
                    @if($unreadCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route(auth()->user()->dashboardRoute()) }}" class="block px-5 py-3 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">
                    Mon espace
                </a>
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf @method('DELETE')
                    <button class="block w-full px-5 py-3 rounded-xl bg-red-50 text-red-600 font-semibold hover:bg-red-100 transition">Déconnexion</button>
                </form>
            @endauth
        </div>
    </nav>
</header>
