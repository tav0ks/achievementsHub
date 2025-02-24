<x-guest-layout>
    <div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-8 space-y-6">
        <!-- Cabeçalho -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                {{ __('Reset Password') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('Enter your email to receive a password reset link.') }}
            </p>
        </div>

        <!-- Mensagem de status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Formulário -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Campo de e-mail -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" class="sr-only" />
                <div class="relative">
                    <x-text-input 
                        id="email" 
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        placeholder="{{ __('Enter your email') }}" />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
            </div>

            <!-- Botão de envio -->
            <div>
                <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                    {{ __('Send Reset Link') }}
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </x-primary-button>
            </div>
        </form>

        <!-- Link de retorno -->
        <div class="text-center">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 transition duration-200">
                {{ __('Back to login') }}
            </a>
        </div>
    </div>
</x-guest-layout>