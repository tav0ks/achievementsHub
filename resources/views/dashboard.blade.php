<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (empty($steamData))
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col items-center gap-3">
                        {{ __('Connect your steam account!') }}
                        <a href="{{ route('profile.edit') }}"
                            class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded">Connect</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Seção de Perfil Steam -->
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $steamData['playerSummary']['avatarfull'] }}" alt="Avatar"
                            class="w-20 h-20 rounded-full">
                        <div>
                            <h3 class="text-2xl font-bold text-white">{{ $steamData['playerSummary']['personaname'] }}
                            </h3>
                            <a href="{{ $steamData['playerSummary']['profileurl'] }}" target="_blank"
                                class="text-sky-400 hover:text-sky-300">
                                Ver perfil na Steam
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jogos Recentes com Header -->
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-white mb-4">Jogados Recentemente</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($steamData['recentlyPlayed'] as $game)
                            <div
                                class="relative group overflow-hidden rounded-lg h-48 hover:transform hover:scale-105 transition-all duration-300">
                                <img src="{{ $game['header'] }}" alt="{{ $game['name'] }}"
                                    class="w-full h-full object-cover absolute inset-0"
                                    onerror="this.style.display='none'">
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 to-transparent p-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $game['icon'] }}" alt="Ícone" class="w-12 h-12">
                                        <div>
                                            <h4 class="text-lg font-bold text-white">{{ $game['name'] }}</h4>
                                            <p class="text-gray-300 text-sm">
                                                {{ round($game['playtime_forever'] / 60) }} horas jogadas
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Jogos da Biblioteca -->
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-white mb-4">Mais Jogados</h3>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="col-span-2 bg-gray-700 p-6 rounded-lg">
                            <p class="text-3xl font-bold text-white">{{ $steamData['ownedGamesCount'] }}</p>
                            <p class="text-gray-300">Jogos na biblioteca</p>
                        </div>
                        @foreach ($steamData['topGames'] as $game)
                            <div
                                class="relative group overflow-hidden rounded-lg h-48 hover:transform hover:scale-105 transition-all duration-300">
                                <img src="{{ $game['header'] }}" alt="{{ $game['name'] }}"
                                    class="w-full h-full object-cover absolute inset-0"
                                    onerror="this.style.display='none'">
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 to-transparent p-4">
                                    <p class="text-white font-medium truncate">{{ $game['name'] }}</p>
                                    <p class="text-gray-300 text-sm">
                                        {{ round($game['playtime_forever'] / 60) }}h
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Amigos -->
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-white mb-4">Amigos</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach ($steamData['friends'] as $friend)
                            <div class="bg-gray-700 p-4 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $friend['avatar'] }}" alt="Avatar" class="w-12 h-12 rounded-full">
                                    <div>
                                        <p class="text-white font-medium">{{ $friend['personaname'] }}</p>
                                        <p class="text-gray-300 text-sm">
                                            Status: {{ $friend['personastate'] ? 'Online' : 'Offline' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Amigos -->
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-white mb-4">Me mata de uma vez</h3>
                    <iframe width="110" height="200"
                        src="https://www.myinstants.com/instant/me-mata-de-uma-vez-31687/embed/" frameborder="0"
                        scrolling="no"></iframe>
                </div>
            </div>
        </div>

    @endif

    <!-- Seção RetroAchievements -->
    @if (!empty($retroData))
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-white mb-4">RetroAchievements</h3>

                    <!-- Perfil -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="col-span-1 flex items-center space-x-4">
                            <img src="{{ $retroData['profile']['avatar'] }}" alt="Avatar"
                                class="w-20 h-20 rounded-full">
                            <div>
                                <h4 class="text-2xl font-bold text-white">{{ $retroData['profile']['username'] }}</h4>
                                <p class="text-gray-300">Membro desde
                                    {{ date('d/m/Y', strtotime($retroData['profile']['memberSince'])) }}</p>
                            </div>
                        </div>

                        <div class="col-span-2 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-gray-700 p-4 rounded-lg">
                                <p class="text-3xl font-bold text-white">
                                    {{ number_format($retroData['profile']['totalPoints']) }}</p>
                                <p class="text-gray-300">Pontos</p>
                            </div>
                            <div class="bg-gray-700 p-4 rounded-lg">
                                <p class="text-3xl font-bold text-white">
                                    {{ number_format($retroData['profile']['totalTruePoints']) }}</p>
                                <p class="text-gray-300">Pontos Reais</p>
                            </div>
                            <div class="col-span-2 bg-gray-700 p-4 rounded-lg">
                                <p class="text-white font-medium">Jogando agora:</p>
                                <p class="text-gray-300 truncate">
                                    {{ $retroData['profile']['richPresence'] ?? 'Nenhum jogo ativo' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Jogos Recentes -->
                    @if (!empty($retroData['recentGames']))
                        <div class="mt-8">
                            <h4 class="text-lg font-semibold text-white mb-4">Jogados Recentemente</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach ($retroData['recentGames'] as $game)
                                    <div class="bg-gray-700 p-4 rounded-lg">
                                        <div class="flex items-center space-x-4">
                                            <img src="https://retroachievements.org{{ $game['ImageIcon'] }}"
                                                alt="{{ $game['Title'] }}" class="w-16 h-16">
                                            <div>
                                                <p class="text-white font-medium">{{ $game['Title'] }}</p>
                                                <p class="text-gray-300 text-sm">
                                                    Conquistas:
                                                    {{ $game['NumAchieved'] }}/{{ $game['AchievementsTotal'] }}
                                                </p>
                                                <p class="text-gray-300 text-sm">
                                                    Pontos: {{ $game['ScoreAchieved'] }}/{{ $game['PossibleScore'] }}
                                                </p>
                                                <p class="text-gray-300 text-sm">
                                                    Última vez: {{ date('d/m/Y', strtotime($game['LastPlayed'])) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

</x-app-layout>
