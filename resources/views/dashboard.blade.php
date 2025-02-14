<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (!Auth::user()->steam_id)
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
        @if (isset($playerSummary))
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $playerSummary['avatarfull'] }}" alt="Avatar" class="w-20 h-20 rounded-full">
                            <div>
                                <h3 class="text-2xl font-bold text-white">{{ $playerSummary['personaname'] }}</h3>
                                <a href="{{ $playerSummary['profileurl'] }}" target="_blank"
                                    class="text-sky-400 hover:text-sky-300">
                                    Ver perfil na Steam
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Jogos Recentes -->
        @if (!empty($recentlyPlayed))
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-white mb-4">Jogados Recentemente</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($recentlyPlayed as $game)
                                <div class="bg-gray-700 p-4 rounded-lg hover:bg-gray-600 transition">
                                    <img src="{{ $game['icon'] }}" alt="{{ $game['name'] }}"
                                        class="w-16 h-16 mx-auto mb-2 rounded-lg">
                                    <h4 class="text-lg font-medium text-white text-center">{{ $game['name'] }}</h4>
                                    <p class="text-gray-300 text-center">
                                        {{ round($game['playtime_forever'] / 60) }} horas
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Biblioteca de Jogos -->
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-white mb-4">Biblioteca</h3>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="col-span-2 bg-gray-700 p-6 rounded-lg">
                            <p class="text-3xl font-bold text-white">{{ $ownedGamesCount }}</p>
                            <p class="text-gray-300">Jogos na biblioteca</p>
                        </div>
                        @foreach ($topGames as $game)
                            <div class="bg-gray-700 p-4 rounded-lg">
                                <img src="{{ $game['icon'] }}" alt="{{ $game['name'] }}"
                                    class="w-12 h-12 mx-auto mb-2">
                                <p class="text-white text-center text-sm">{{ $game['name'] }}</p>
                                <p class="text-gray-300 text-center text-xs">
                                    {{ round($game['playtime_forever'] / 60) }}h
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Amigos -->
        @if (!empty($friends))
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-white mb-4">Amigos</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($friends as $friend)
                                <div class="bg-gray-700 p-4 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $friend['avatar'] }}" alt="Avatar"
                                            class="w-12 h-12 rounded-full">
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
        @endif

    @endif

</x-app-layout>
