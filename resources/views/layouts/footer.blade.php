<footer class="relative overflow-hidden bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 text-white mt-20">

    <!-- Décoration -->
    <div class="absolute top-0 left-0 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-400/10 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-6 py-16 relative z-10">

        <div class="grid lg:grid-cols-4 gap-12">

            <!-- Logo -->
            <div>

                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center">

                        <i class="fa-solid fa-landmark text-2xl"></i>

                    </div>

                    <div>

                        <h3 class="text-2xl font-bold">

                            Plateforme

                        </h3>

                        <p class="text-blue-200">

                            Gestion des Plaintes

                        </p>

                    </div>

                </div>

                <p class="mt-6 text-blue-100 leading-7">

                    Une plateforme numérique permettant aux citoyens de signaler
                    rapidement les problèmes rencontrés auprès des services publics
                    et de suivre leur résolution en toute transparence.

                </p>

            </div>

            <!-- Navigation -->

            <div>

                <h4 class="text-xl font-semibold mb-6">

                    Navigation

                </h4>

                <ul class="space-y-4">

                    <li>

                        <a href="{{ route('index') }}"
                           class="flex items-center gap-3 text-blue-100 hover:text-white transition">

                            <i class="fa-solid fa-house w-5"></i>

                            Accueil

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('services') }}"
                           class="flex items-center gap-3 text-blue-100 hover:text-white transition">

                            <i class="fa-solid fa-building w-5"></i>

                            Services

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('complaints.index') }}"
                           class="flex items-center gap-3 text-blue-100 hover:text-white transition">

                            <i class="fa-solid fa-file-circle-exclamation w-5"></i>

                            Plaintes

                        </a>

                    </li>

                </ul>

            </div>

            <!-- Contact -->

            <div>

                <h4 class="text-xl font-semibold mb-6">

                    Contact

                </h4>

                <div class="space-y-5">

                    <div class="flex gap-4">

                        <i class="fa-solid fa-envelope mt-1 text-cyan-300"></i>

                        <span class="text-blue-100">

                            contact@plaintes.gov

                        </span>

                    </div>

                    <div class="flex gap-4">

                        <i class="fa-solid fa-phone mt-1 text-cyan-300"></i>

                        <span class="text-blue-100">

                            +221 33 123 45 67

                        </span>

                    </div>

                    <div class="flex gap-4">

                        <i class="fa-solid fa-location-dot mt-1 text-cyan-300"></i>

                        <span class="text-blue-100">

                            Ministère des Services Publics

                        </span>

                    </div>

                </div>

            </div>

            <!-- Statistiques -->

            <div>

                <h4 class="text-xl font-semibold mb-6">

                    Plateforme

                </h4>

                <div class="space-y-5">

                    <div>

                        <h2 class="text-3xl font-bold">

                            15K+

                        </h2>

                        <p class="text-blue-200">

                            Plaintes enregistrées

                        </p>

                    </div>

                    <div>

                        <h2 class="text-3xl font-bold">

                            93%

                        </h2>

                        <p class="text-blue-200">

                            Plaintes résolues

                        </p>

                    </div>

                    <div>

                        <h2 class="text-3xl font-bold">

                            24/7

                        </h2>

                        <p class="text-blue-200">

                            Disponible

                        </p>

                    </div>

                </div>

            </div>

        </div>

        <!-- Barre inférieure -->

        <div class="border-t border-white/10 mt-16 pt-8">

            <div class="flex flex-col md:flex-row justify-between items-center gap-6">

                <p class="text-blue-200">

                    © {{ date('Y') }} Plateforme de Gestion des Plaintes.
                    Tous droits réservés.

                </p>

                <div class="flex items-center gap-5 text-xl">

                    <a href="#" class="hover:text-cyan-300 transition">

                        <i class="fa-brands fa-facebook"></i>

                    </a>

                    <a href="#" class="hover:text-cyan-300 transition">

                        <i class="fa-brands fa-x-twitter"></i>

                    </a>

                    <a href="#" class="hover:text-cyan-300 transition">

                        <i class="fa-brands fa-linkedin"></i>

                    </a>

                    <a href="#" class="hover:text-cyan-300 transition">

                        <i class="fa-brands fa-youtube"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>

</footer>