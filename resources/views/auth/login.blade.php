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
            </div>
        </div>

    </x-authentication-card>
</x-guest-layout>
