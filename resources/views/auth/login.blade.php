<x-guest-layout>
    {{-- <div class="min-h-screen flex flex-col sm:justify-center items-center sm:pt-0"> --}}
        <div class="w-full sm:max-w-md px-6 py-8 bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <!-- Logo/Cabeçalho -->
            <div class="flex flex-col items-center mb-8">
                <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
                <p class="text-gray-400">Sign in to continue</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
                    <x-text-input 
                        id="email" 
                        class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password Input -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
                    <x-text-input 
                        id="password" 
                        class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password" 
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            class="rounded bg-gray-700 border-gray-600 text-indigo-500 focus:ring-indigo-600 focus:ring-offset-gray-800" 
                            name="remember"
                        >
                        <span class="ms-2 text-sm text-gray-300">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a 
                            href="{{ route('password.request') }}" 
                            class="text-sm text-indigo-400 hover:text-indigo-300 underline"
                        >
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-500">
                    {{ __('Sign In') }}
                </x-primary-button>

                <!-- Divider -->
                <div class="relative flex items-center py-4">
                    <div class="flex-grow border-t border-gray-600"></div>
                    <span class="flex-shrink mx-4 text-gray-400">Or continue with</span>
                    <div class="flex-grow border-t border-gray-600"></div>
                </div>

                <!-- Google Login -->
                <div>
                    <a 
                        href="{{ route('auth.google') }}" 
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-gray-600 rounded-lg 
                               hover:bg-gray-700 transition-colors duration-200"
                    >
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0012.545 2C7.021 2 2.545 6.477 2.545 12s4.476 10 10 10c5.523 0 10-4.477 10-10a9.982 9.982 0 00-2.909-7.071l-2.541 2.541z"/>
                        </svg>
                        <span class="text-gray-300 font-medium">Google</span>
                    </a>
                </div>

                <!-- Register Link -->
                @if (Route::has('register'))
                    <p class="text-sm text-gray-400 text-center mt-6">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 underline">
                            Sign up
                        </a>
                    </p>
                @endif
            </form>
        </div>
    {{-- </div> --}}
</x-guest-layout>