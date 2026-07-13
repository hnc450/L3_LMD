@php
    $user = auth()->user();
    $role = $user?->role?->name;
@endphp

<aside class="w-72 bg-gradient-to-br from-slate-950 via-blue-950 to-blue-900 text-white min-h-screen flex-shrink-0 hidden lg:flex flex-col shadow-2xl">

    {{-- Logo --}}
    <div class="p-6 border-b border-white/10">
        <a href="{{ route('index') }}" class="flex items-center gap-4 group">

            <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                <i class="fa-solid fa-landmark text-xl text-blue-200"></i>
            </div>

            <div>
                <h1 class="font-bold text-lg tracking-wide">
                    Plateforme
                </h1>

                <span class="inline-flex items-center mt-1 px-3 py-1 rounded-full text-xs bg-blue-500/20 text-blue-200 capitalize">
                    {{ $role ?? 'Public' }}
                </span>
            </div>

        </a>
    </div>


    {{-- Navigation --}}
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">


        {{-- ADMIN --}}
        @if($role === 'admin')

            @php
                $menus = [
                    ['route'=>'admin.index','icon'=>'fa-gauge','label'=>'Tableau de bord'],
                    ['route'=>'complaints.index','icon'=>'fa-file-circle-exclamation','label'=>'Plaintes'],
                    ['route'=>'admin.users','icon'=>'fa-users','label'=>'Utilisateurs'],
                    ['route'=>'admin.services.index','icon'=>'fa-building','label'=>'Services'],
                    ['route'=>'admin.roles.index','icon'=>'fa-user-shield','label'=>'Rôles'],
                    ['route'=>'admin.statistics','icon'=>'fa-chart-bar','label'=>'Statistiques'],
                    ['route'=>'admin.logs','icon'=>'fa-clock-rotate-left','label'=>'Logs'],
                    ['route'=>'notifications.index','icon'=>'fa-bell','label'=>'Notifications'],
                ];
            @endphp

            @foreach($menus as $menu)

                <a href="{{ route($menu['route']) }}"
                   class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300
                   {{ request()->routeIs($menu['route'].'*') 
                        ? 'bg-white/20 text-white shadow-lg translate-x-1' 
                        : 'text-blue-100 hover:bg-white/10 hover:translate-x-1' }}">

                    <i class="fa-solid {{ $menu['icon'] }} w-5 text-center
                    group-hover:scale-110 transition"></i>

                    <span class="text-sm font-medium">
                        {{ $menu['label'] }}
                    </span>

                </a>

            @endforeach


        {{-- AGENT --}}
        @elseif($role === 'agent')

            @foreach([
                ['route'=>'agent.index','icon'=>'fa-gauge','label'=>'Mes plaintes'],
                ['route'=>'notifications.index','icon'=>'fa-bell','label'=>'Notifications'],
                ['route'=>'agent.logs','icon'=>'fa-clock-rotate-left','label'=>'Mes logs'],
            ] as $menu)
            <a href="{{ route($menu['route']) }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition {{ request()->routeIs($menu['route'].'*') ? 'bg-white/20' : '' }}">
                <i class="fa-solid {{ $menu['icon'] }} w-5"></i>
                <span>{{ $menu['label'] }}</span>
            </a>
            @endforeach

        {{-- RESPONSABLE --}}
        @elseif($role === 'responsable')

            @foreach([
                ['route'=>'responsable.index','icon'=>'fa-gauge','label'=>'Tableau de bord'],
                ['route'=>'responsable.agents','icon'=>'fa-user-tie','label'=>'Mes agents'],
                ['route'=>'responsable.statistics','icon'=>'fa-chart-bar','label'=>'Statistiques'],
                ['route'=>'responsable.logs','icon'=>'fa-clock-rotate-left','label'=>'Mes logs'],
                ['route'=>'notifications.index','icon'=>'fa-bell','label'=>'Notifications'],
            ] as $menu)
            <a href="{{ route($menu['route']) }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/10 transition {{ request()->routeIs($menu['route'].'*') ? 'bg-white/20' : '' }}">
                <i class="fa-solid {{ $menu['icon'] }} w-5"></i>
                <span>{{ $menu['label'] }}</span>
            </a>
            @endforeach


        {{-- CITOYEN --}}
        @elseif($role === 'citoyen')

            @php
                $menus = [
                    ['route'=>'user.dashboard','icon'=>'fa-gauge','label'=>'Tableau de bord'],
                    ['route'=>'complaints.create','icon'=>'fa-plus','label'=>'Nouvelle plainte'],
                    ['route'=>'notifications.index','icon'=>'fa-bell','label'=>'Notifications'],
                    ['route'=>'user.logs','icon'=>'fa-clock-rotate-left','label'=>'Mes logs'],
                    ['route'=>'user.profile','icon'=>'fa-user','label'=>'Profil'],
                    ['route'=>'user.settings','icon'=>'fa-gear','label'=>'Paramètres'],
                ];
            @endphp

            @foreach($menus as $menu)

                <a href="{{ route($menu['route']) }}"
                class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300
                {{ request()->routeIs($menu['route'].'*') 
                    ? 'bg-white/20 text-white shadow-lg translate-x-1'
                    : 'text-blue-100 hover:bg-white/10 hover:translate-x-1' }}">


                    <i class="fa-solid {{ $menu['icon'] }} w-5 group-hover:scale-110 transition"></i>


                    <span class="text-sm font-medium">
                        {{ $menu['label'] }}
                    </span>


                </a>

            @endforeach

        @endif
    </nav>

    {{-- USER CARD --}}
    @auth

    <div class="p-5 border-t border-white/10">

        <div class="flex items-center gap-3 bg-white/5 rounded-2xl p-3 backdrop-blur">


            <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 flex items-center justify-center font-bold shadow-lg">

                {{ strtoupper(substr($user->name,0,1)) }}

            </div>

            <div class="flex-1 min-w-0">

                <p class="text-sm font-semibold truncate">
                    {{ $user->name }}
                </p>


                <p class="text-xs text-blue-300 truncate">
                    {{ $user->email }}
                </p>

            </div>

        </div>

        <form method="POST" action="{{ route('auth.logout') }}" class="mt-4">

            @csrf
            @method('DELETE')

            <button
            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
            text-blue-200 hover:text-white hover:bg-red-500/20
            transition">
                <i class="fa-solid fa-right-from-bracket"></i>
                Déconnexion
            </button>
        </form>
    </div>
    @endauth
</aside>