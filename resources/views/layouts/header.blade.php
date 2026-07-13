<header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm">
    <nav class="container mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16 sm:h-20">
            <a href="{{ route('index') }}" class="flex items-center gap-2 sm:gap-3 group">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-r from-blue-700 to-cyan-500 flex items-center justify-center shadow-lg">
                    <i class="fa-solid fa-landmark text-white text-lg sm:text-xl"></i>
                </div>
                <div>
                    <h2 class="text-base sm:text-xl font-bold text-gray-800 group-hover:text-blue-700 transition">Plateforme</h2>
                    <p class="text-xs sm:text-sm text-gray-500 hidden sm:block">Gestion des plaintes</p>
                </div>
            </a>

            <div class="flex items-center gap-2 sm:gap-4">
                @guest
                    <a href="{{ route('auth.login') }}" class="text-gray-700 hover:text-blue-700 font-medium text-sm sm:text-base px-2 sm:px-0">Connexion</a>
                    <a href="{{ route('auth.register') }}" class="px-4 py-2 sm:px-6 sm:py-3 rounded-xl bg-gradient-to-r from-blue-700 to-cyan-500 text-white font-semibold shadow-lg hover:scale-105 transition text-sm sm:text-base">
                        Inscription
                    </a>
                @endguest
                @auth
                    <a href="{{ route('notifications.index') }}" class="relative px-3 py-2 sm:px-5 sm:py-3 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">
                        <i class="fa-solid fa-bell"></i>
                        @php
                            $unreadCount = \App\Models\Notification::where('id_user', auth()->id())->where('status', 'sent')->count();
                            if(auth()->user()->isResponsable()) {
                                $unreadCount += \App\Models\Rapport::where('responsable_id', auth()->id())->where('is_read', false)->count();
                            }
                        @endphp
                        @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full h-4 w-4 sm:h-5 sm:w-5 flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route(auth()->user()->dashboardRoute()) }}" class="hidden sm:block px-5 py-3 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">
                        Mon espace
                    </a>
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf @method('DELETE')
                        <button class="px-3 py-2 sm:px-5 sm:py-3 rounded-xl bg-red-50 text-red-600 font-semibold hover:bg-red-100 transition text-sm sm:text-base">Déconnexion</button>
                    </form>
                @endauth
            </div>
        </div>
        @auth
        <ul class="flex lg:hidden items-center gap-4 font-medium text-sm pb-3 border-t border-gray-200 pt-3">
            <li><a href="{{ route('index') }}" class="text-gray-700 hover:text-blue-700 transition">Accueil</a></li>
            <li><a href="{{ route('services') }}" class="text-gray-700 hover:text-blue-700 transition">Services</a></li>
            <li><a href="{{ route('complaints.create') }}" class="text-gray-700 hover:text-blue-700 transition">Déposer une plainte</a></li>
            <li><a href="{{ route('public.track.form') }}" class="text-gray-700 hover:text-blue-700 transition">Suivi</a></li>
            <li><a href="{{ route(auth()->user()->dashboardRoute()) }}" class="text-gray-700 hover:text-blue-700 transition">Mon espace</a></li>
        </ul>
        @endauth
        @guest
        <ul class="flex lg:hidden items-center gap-4 font-medium text-sm pb-3 border-t border-gray-200 pt-3">
            <li><a href="{{ route('index') }}" class="text-gray-700 hover:text-blue-700 transition">Accueil</a></li>
            <li><a href="{{ route('services') }}" class="text-gray-700 hover:text-blue-700 transition">Services</a></li>
            <li><a href="{{ route('complaints.create') }}" class="text-gray-700 hover:text-blue-700 transition">Déposer une plainte</a></li>
            <li><a href="{{ route('public.track.form') }}" class="text-gray-700 hover:text-blue-700 transition">Suivi</a></li>
        </ul>
        @endguest
    </nav>
</header>
