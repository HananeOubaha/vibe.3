<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>

        <!-- Boutons de connexion sociale -->
        <div class="mt-8">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 text-gray-500 bg-white">Ou connectez-vous avec</span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-3">
                <!-- Bouton Google -->
                <a href="{{ route('social.redirect', 'google') }}"
                    class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg"
                        class="h-5 w-5 mr-2"
                        alt="Google logo">
                    <span>Continuer avec Google</span>
                </a>

                <!-- Bouton Facebook -->
                <a href="{{ route('social.redirect', 'facebook') }}"
                    class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-transparent rounded-md shadow-sm bg-[#1877F2] text-sm font-medium text-white hover:bg-[#0c64d3] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1877F2] transition-all duration-200">
                    <img src="https://www.svgrepo.com/show/303114/facebook-3-logo.svg"
                        class="h-5 w-5 mr-2"
                        alt="Facebook logo">
                    <span>Continuer avec Facebook</span>
                </a>

                <!-- Bouton GitHub -->
                <a href="{{ route('social.redirect', 'github') }}"
                    class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-transparent rounded-md shadow-sm bg-[#24292F] text-sm font-medium text-white hover:bg-[#1a1e23] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#24292F] transition-all duration-200">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
                    </svg>
                    <span>Continuer avec GitHub</span>
                </a>
            </div>
        </div>

    </x-authentication-card>
</x-guest-layout>



