<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- <div>
            <x-input-label for="steam_id" :value="__('Steam ID')" />
            <x-text-input id="steam_id" name="steam_id" type="text" class="mt-1 block w-full" :value="old('steam_id', $user->steam_id)" autofocus autocomplete="steam_id" />
            <x-input-error class="mt-2" :messages="$errors->get('steam_id')" />
        </div> --}}
        <div class="space-y-6">
            <!-- Steam ID Card -->
            <div x-data="{
                steamId: '{{ old('steam_id', $user->steam_id) }}',
                isValid: {{ $user->steam_id ? 'true' : 'false' }},
                isLoading: false,
                checkSteamId() {
                    this.isLoading = true;
                    // Simula verificação assíncrona
                    setTimeout(() => {
                        this.isValid = this.steamId.length > 0;
                        this.isLoading = false;
                    }, 1000);
                }
            }" @input.debounce.500ms="checkSteamId"
                class="relative mx-auto flex flex-col max-w-full items-center gap-4 rounded-xl p-6 shadow-lg transition-all duration-300
          outline outline-[3px] dark:shadow-none hover:scale-105
          @if ($user->steam_id)
outline-green-500/70 bg-green-500/5
@else
outline-red-500/70 bg-red-500/5
@endif
                    dark:@if ($user->steam_id)
outline-green-400/70 dark:bg-green-500/10
@else
outline-red-400/70 dark:bg-red-500/10
@endif">

                <div class="absolute top-3 right-3">
                    <!-- Spinner -->
                    <svg x-show="isLoading" class="animate-spin h-5 w-5 text-blue-500"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>

                    <!-- Checkmark -->
                    <svg x-show="!isLoading && isValid" class="h-6 w-6 text-green-500 dark:text-green-400"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>

                    <!-- Error Icon -->
                    <svg x-show="!isLoading && !isValid" class="h-6 w-6 text-red-500 dark:text-red-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </div>

                <img src="https://upload.wikimedia.org/wikipedia/commons/8/83/Steam_icon_logo.svg" alt="Steam Logo"
                    class="h-12 w-12">

                <div class="text-center">
                    <div class="text-xl font-medium text-gray-900 dark:text-white">Steam ID</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ __('*Your profile must be set to PUBLIC') }}
                        <span class="inline-block" x-tooltip="'We need public access to fetch your game data'">
                            <svg class="h-4 w-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </p>
                </div>

                <x-text-input x-model="steamId" id="steam_id" name="steam_id" type="text"
                    class="mt-1 block w-full transition-all duration-300
                   @if ($user->steam_id) border-green-500 focus:ring-green-500 @else border-red-500 focus:ring-red-500 @endif
                   dark:@if ($user->steam_id) border-green-400 focus:ring-green-400 @else border-red-400 focus:ring-red-400 @endif"
                    autofocus autocomplete="steam_id" />
            </div>

            <!-- RetroAchievements Card -->
            <div x-data="{
                retroUser: '{{ old('retroachievements_username', $user->retroachievements_username) }}',
                isValid: {{ $user->retroachievements_username ? 'true' : 'false' }},
                isLoading: false,
                checkRetroUser() {
                    this.isLoading = true;
                    setTimeout(() => {
                        this.isValid = this.retroUser.length > 0;
                        this.isLoading = false;
                    }, 1000);
                }
            }" @input.debounce.500ms="checkRetroUser"
                class="relative mx-auto flex flex-col max-w-full items-center gap-4 rounded-xl p-6 shadow-lg transition-all duration-300
          outline outline-[3px] dark:shadow-none hover:scale-105
          @if ($user->retroachievements_username)
            outline-green-500/70 bg-green-500/5
            @else
            outline-red-500/70 bg-red-500/5
            @endif
                                dark:@if ($user->retroachievements_username)
            outline-green-400/70 dark:bg-green-500/10
            @else
            outline-red-400/70 dark:bg-red-500/10
            @endif">

                <div class="absolute top-3 right-3">
                    <!-- Spinner -->
                    <svg x-show="isLoading" class="animate-spin h-5 w-5 text-blue-500"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>

                    <!-- Checkmark -->
                    <svg x-show="!isLoading && isValid" class="h-6 w-6 text-green-500 dark:text-green-400"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>

                    <!-- Error Icon -->
                    <svg x-show="!isLoading && !isValid" class="h-6 w-6 text-red-500 dark:text-red-400"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </div>

                <img src="https://static.retroachievements.org/assets/images/ra-icon.webp"
                    alt="RetroAchievements Logo" class="h-8 w-12">

                <div class="text-center">
                    <div class="text-xl font-medium text-gray-900 dark:text-white">RetroAchievements</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ __('Your RetroAchievements username') }}
                        <span class="inline-block" x-tooltip="'We need this to fetch your achievements'">
                            <svg class="h-4 w-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </p>
                </div>

                <x-text-input x-model="retroUser" id="retroachievements_username" name="retroachievements_username"
                    type="text"
                    class="mt-1 block w-full transition-all duration-300
                   @if ($user->retroachievements_username) border-green-500 focus:ring-green-500 @else border-red-500 focus:ring-red-500 @endif
                   dark:@if ($user->retroachievements_username) border-green-400 focus:ring-green-400 @else border-red-400 focus:ring-red-400 @endif"
                    autocomplete="retroachievements_username" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
