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
        <div class="mt-6">
            <p class="text-center text-gray-500 font-medium">Ou connectez-vous avec</p>

            <div class="flex justify-center mt-4 space-x-4">
                <!-- Bouton Google -->
                <a href="{{ route('social.redirect', 'google') }}"
                    class="flex items-center px-6 py-2 text-white bg-red-500 hover:bg-red-600 rounded-lg shadow-md transition-all">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5 mr-2" alt="Google logo">
                    Connexion avec Google
                </a>

                <!-- Bouton Facebook -->
                <a href="{{ route('social.redirect', 'facebook') }}"
                    class="flex items-center px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition-all">
                    <img src="https://www.svgrepo.com/show/303114/facebook-3-logo.svg" class="w-5 h-5 mr-2" alt="Facebook logo">
                    Connexion avec Facebook
                </a>
            </div>
        </div>

    </x-authentication-card>
</x-guest-layout>
