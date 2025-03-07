<x-app-layout>
    <div class="flex flex-col md:flex-row justify-between items-start min-h-screen bg-black text-gray-100">
        <!-- Sidebar Left -->
        <div class="w-full md:w-72 border-r border-gray-800">
            <x-sidebar-left />
        </div>
        <!-- Main Content -->
        <div class="flex-1 max-w-6xl mx-auto px-12   py-6">
            <!-- Header Section -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-white mb-2 flex items-center">
                    <i class="fas fa-users text-indigo-500 mr-3"></i>
                    Amis
                </h1>
                <p class="text-gray-400 text-sm">Retrouvez et connectez-vous avec vos amis</p>
            </div>

            <!-- Friends Grid -->
            <div class="bg-gray-900 rounded-lg shadow-lg p-4 mb-6">
                <h3 class="text-lg font-semibold text-white mb-4">Contacts</h3>

                <!-- Online Friends -->
                <h4 class="text-green-500 font-medium text-sm mb-2">En ligne</h4>
                <div class="space-y-1">
                    @foreach($amisEnLigne as $ami)
                        <a href="/chatify" class="flex items-center p-2 rounded-lg hover:bg-gray-800 transition duration-150">
                            <div class="relative h-12 w-12 rounded-full overflow-hidden border border-gray-700">
                                <img src="{{ $ami->profile_photo_url ? asset($ami->profile_photo_url) : 'https://via.placeholder.com/50' }}"
                                     alt="{{ $ami->pseudo }}"
                                     class="h-full w-full object-cover">
                                <span class="absolute bottom-1 right-1 block h-4 w-4 rounded-full bg-green-500 border-2 border-gray-900"></span>
                            </div>
                            <span class="ml-3 text-gray-200 font-medium text-sm">{{ $ami->pseudo }}</span>
                        </a>
                    @endforeach
                </div>

                <!-- Offline Friends -->
                <h4 class="text-gray-400 font-medium text-sm mt-4 mb-2">Hors ligne</h4>
                <div class="space-y-1">
                    @foreach($amisHorsLigne as $ami)
                        <a href="/chatify" class="flex items-center p-2 rounded-lg hover:bg-gray-800 transition duration-150">
                            <div class="relative h-12 w-12 rounded-full overflow-hidden border border-gray-700">
                                <img src="{{ $ami->profile_photo_url ? asset($ami->profile_photo_url) : 'https://via.placeholder.com/50' }}"
                                     alt="{{ $ami->pseudo }}"
                                     class="h-full w-full object-cover">
                                <span class="absolute bottom-1 right-1 block h-4 w-4 rounded-full bg-gray-500 border-2 border-gray-900"></span>
                            </div>
                            <span class="ml-3 text-gray-300 font-medium text-sm">{{ $ami->pseudo }}</span>
                        </a>
                    @endforeach
                </div>

{{--                <a href="{{ route('showallamis') }}" class="block text-indigo-500 hover:text-indigo-400 text-sm mt-4 font-medium">Voir tous les amis</a>--}}
            </div>
        </div>
        <!-- Right Sidebar -->
{{--        <div class="w-full md:w-80 bg-gray-900 border-l border-gray-800 p-4 shadow overflow-y-auto h-auto md:h-screen">--}}
{{--            <h2 class="text-lg font-semibold text-white mb-4 flex items-center">--}}
{{--                <i class="fas fa-bell text-indigo-500 mr-2"></i> Activités Récentes--}}
{{--            </h2>--}}
{{--            <div class="space-y-3">--}}
{{--                <div class="flex items-start p-3 bg-gray-800 rounded-lg hover:bg-gray-700 transition duration-150">--}}
{{--                    <div class="w-8 h-8 rounded-full overflow-hidden">--}}
{{--                        <img src="https://via.placeholder.com/50" alt="Activity" class="w-full h-full object-cover">--}}
{{--                    </div>--}}
{{--                    <div class="ml-2">--}}
{{--                        <p class="text-sm text-white"><span class="font-semibold">Marie Dupont</span> a partagé une publication</p>--}}
{{--                        <p class="text-xs text-gray-400">Il y a 20 minutes</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</x-app-layout>
