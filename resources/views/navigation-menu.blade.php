<nav x-data="{ open: false }" class="bg-gradient-to-r from-purple-900 via-indigo-800 to-blue-900 border-b border-indigo-400 shadow-lg sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo - Redesigned with glowing effect -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('posts.index') }}" class="transition-transform duration-300 transform hover:scale-110">
                        <div class="bg-gradient-to-br from-purple-500 to-indigo-600 h-10 w-10 rounded-full flex items-center justify-center shadow-md relative overflow-hidden group">
                            <span class="text-white font-bold text-xl">
                                <x-authentication-card-logo />
                            </span>
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        </div>
                    </a>
                </div>

                <x-search-results :users="$users ?? []" />

                <!-- Navigation Links with glass-like effect -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('dashboard')" class="text-indigo-200 hover:text-white transition-all duration-200 border-b-2 border-transparent hover:border-indigo-400">
                        <i class="fas fa-home text-xl mr-2"></i> {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('afficherDemandesAmitie') }}" :active="request()->routeIs('afficherDemandesAmitie')" class="text-indigo-200 hover:text-white transition-all duration-200 border-b-2 border-transparent hover:border-indigo-400">
                        <i class="fas fa-user-friends text-xl mr-2"></i> {{ __('demande') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('showallamis') }}" :active="request()->routeIs('showallamis')" class="text-indigo-200 hover:text-white transition-all duration-200 border-b-2 border-transparent hover:border-indigo-400">
                        <i class="fas fa-users text-xl mr-2"></i> {{ __('List Amis') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Action buttons with pulsing effect -->
                <div class="flex space-x-3 mr-3">
                    <!-- Notification Icon -->
                    <button class="p-2 bg-indigo-700 rounded-full text-white hover:bg-indigo-600 transition-all duration-300 relative shadow-md">
                        <i class="fas fa-bell text-lg"></i>
                        <!-- Animated notification badge -->
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-md animate-pulse">
                            3
                        </span>
                    </button>

                    <button class="p-2 bg-indigo-700 rounded-full text-white hover:bg-indigo-600 transition-all duration-300 shadow-md">
                        <i class="fa-brands fa-facebook-messenger text-xl"></i>
                    </button>
                </div>

                <!-- Settings Dropdown with glass morphism effect -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-indigo-400 rounded-full transition focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-50 shadow-md hover:shadow-lg">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-4 py-2 border border-indigo-400 text-sm leading-4 font-medium rounded-full text-white bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:ring-offset-2 transition duration-200 ease-in-out shadow-md">
                                        {{ Auth::user()->name }}
                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-gradient-to-b from-indigo-900 to-purple-900 rounded-md shadow-lg ring-1 ring-indigo-400 ring-opacity-50 backdrop-blur-sm">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-indigo-200 bg-indigo-900 rounded-t-md">
                                    {{ __('Manage Account') }}
                                </div>

                                <x-dropdown-link href="{{ route('profile.show') }}" class="transition duration-150 hover:bg-indigo-800 text-white">
                                    <i class="fas fa-user mr-2 text-indigo-300"></i> {{ __('Profile') }}
                                </x-dropdown-link>

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}" class="transition duration-150 hover:bg-indigo-800 text-white">
                                        <i class="fas fa-key mr-2 text-indigo-300"></i> {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-indigo-600"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf

                                    <x-dropdown-link href="{{ route('logout') }}" class="text-red-300 transition duration-150 hover:bg-indigo-800"
                                                     @click.prevent="$root.submit();">
                                        <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-indigo-200 hover:text-white hover:bg-indigo-800 focus:outline-none focus:bg-indigo-800 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-indigo-900 border-t border-indigo-700 max-h-screen overflow-y-auto">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('dashboard')" class="text-indigo-200 hover:text-white hover:bg-indigo-800">
                <i class="fas fa-home mr-2"></i> {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('afficherDemandesAmitie') }}" :active="request()->routeIs('dashboard')" class="text-indigo-200 hover:text-white hover:bg-indigo-800">
                <i class="fas fa-users mr-2"></i> {{ __('demande') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('showallamis') }}" :active="request()->routeIs('dashboard')" class="text-indigo-200 hover:text-white hover:bg-indigo-800">
                <i class="fas fa-users mr-2"></i> {{ __('List Amis') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-indigo-700">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-indigo-400" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-indigo-300">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="text-indigo-200 hover:text-white hover:bg-indigo-800">
                    <i class="fas fa-user mr-2"></i> {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')" class="text-indigo-200 hover:text-white hover:bg-indigo-800">
                        <i class="fas fa-key mr-2"></i> {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}" class="text-red-300 hover:text-red-200 hover:bg-indigo-800"
                                           @click.prevent="$root.submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
