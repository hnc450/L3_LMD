<header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm">

    <nav class="container mx-auto px-6">

        <div class="flex items-center justify-between h-20">

            <!-- Logo -->

            <a href="{{ route('index') }}" class="flex items-center gap-3 group">

                <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-blue-700 to-cyan-500 flex items-center justify-center shadow-lg">

                    <!-- Heroicon Building Library -->

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-7 h-7 text-white"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-4h6v4M9 10h.01M15 10h.01M9 14h.01M15 14h.01"/>

                    </svg>

                </div>

                <div>

                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-blue-700 transition">

                        Plateforme

                    </h2>

                    <p class="text-sm text-gray-500">

                        Gestion des plaintes

                    </p>

                </div>

            </a>

            <!-- Navigation -->

            <ul class="hidden lg:flex items-center gap-8 font-medium">

                <li>

                    <a href="{{ route('index') }}"
                       class="relative text-gray-700 hover:text-blue-700 transition after:absolute after:left-0 after:-bottom-2 after:h-0.5 after:w-0 after:bg-blue-600 hover:after:w-full after:transition-all">

                        Accueil

                    </a>

                </li>

                <li>

                    <a href="{{ route('services') }}"
                       class="relative text-gray-700 hover:text-blue-700 transition after:absolute after:left-0 after:-bottom-2 after:h-0.5 after:w-0 after:bg-blue-600 hover:after:w-full after:transition-all">

                        Services

                    </a>

                </li>

                <li>

                    <a href="{{ route('roles.index') }}"
                       class="relative text-gray-700 hover:text-blue-700 transition after:absolute after:left-0 after:-bottom-2 after:h-0.5 after:w-0 after:bg-blue-600 hover:after:w-full after:transition-all">

                        Rôles

                    </a>

                </li>

                <li>

                    <a href="{{ route('complaints.index') }}"
                       class="relative text-gray-700 hover:text-blue-700 transition after:absolute after:left-0 after:-bottom-2 after:h-0.5 after:w-0 after:bg-blue-600 hover:after:w-full after:transition-all">

                        Plaintes

                    </a>

                </li>

            </ul>

            <!-- Actions -->

            <div class="flex items-center gap-4">

                @guest

                    <a href="{{ route('auth.login') }}"
                       class="text-gray-700 hover:text-blue-700 font-medium transition">

                        Connexion

                    </a>

                    <a href="{{ route('auth.register') }}"
                       class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-700 to-cyan-500 text-white font-semibold shadow-lg hover:scale-105 transition">

                        Inscription

                    </a>

                @endguest

                @auth

                    <a href="{{ route('dashboard') }}"
                       class="px-5 py-3 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">

                        Tableau de bord

                    </a>

                    <form method="POST" action="{{ route('auth.logout') }}">

                        @csrf
                        @method('DELETE')

                        <button
                            class="px-5 py-3 rounded-xl bg-red-50 text-red-600 font-semibold hover:bg-red-100 transition">

                            Déconnexion

                        </button>

                    </form>

                @endauth

            </div>

        </div>

    </nav>

</header>