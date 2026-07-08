<header class="bg-royal-blue shadow-lg">
    <nav class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <a href="{{ route('index') }}" class="text-white text-2xl font-bold">
                    🏛️ Plateforme de Plaintes
                </a>
            </div>
            <ul class="flex items-center space-x-6">
                <li><a href="{{ route('index') }}" class="text-white hover:text-blue-200 transition-colors">Accueil</a></li>
                @guest
                    <li><a href="{{ route('auth.login') }}" class="text-white hover:text-blue-200 transition-colors">Connexion</a></li>
                    <li><a href="{{ route('auth.register') }}" class="bg-white text-royal-blue px-4 py-2 rounded-lg hover:bg-blue-100 transition-colors font-medium">Inscription</a></li>
                @endguest
                @auth
                    <li><a href="{{ route('dashboard') }}" class="text-white hover:text-blue-200 transition-colors">Tableau de bord</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @method('DELETE')   
                            @csrf
                            <button type="submit" class="text-white hover:text-blue-200 transition-colors">Déconnexion</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
</header>