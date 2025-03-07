<x-app-layout>
    <div class="flex flex-col md:flex-row justify-between items-start min-h-screen gap-6 bg-gradient-to-br from-gray-900 to-indigo-950 mb-8">
        <!-- Sidebar Left -->
        <div class="w-full md:w-72">
            <x-sidebar-left  />
        </div>
        <!-- Main Content -->
        <div class="flex-1 max-w-6xl mx-auto px-4 py-6">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2 flex items-center">
                    <i class="fas fa-users text-indigo-400 mr-3"></i>
                    Mes Amis
                </h1>
                <div class="h-0.5 w-32 bg-indigo-500 rounded-full mb-4"></div>
                <p class="text-indigo-200 text-lg">Retrouvez tous vos amis et connectez-vous avec eux.</p>
            </div>

            <!-- Friends Grid -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-800">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Contacts</h3>

    <!-- Online Friends -->
    <h4 class="text-green-500 font-semibold">🟢 En ligne</h4>
    <div class="space-y-2">
        @foreach($amisEnLigne as $ami)
            <a href="#" class="flex items-center p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                <div class="relative h-12 w-12 rounded-full overflow-hidden border border-gray-300 dark:border-gray-600">
                    <img src="{{ $ami->profile_photo_url ? asset($ami->profile_photo_url) : 'https://via.placeholder.com/50' }}" 
                         alt="{{ $ami->pseudo }}" 
                         class="h-full w-full object-cover">
                    <span class="absolute bottom-1 right-1 block h-3.5 w-3.5 rounded-full bg-green-500 border-2"></span>
                </div>
                <span class="ml-3 text-gray-900 dark:text-white font-medium">{{ $ami->pseudo }}</span>
            </a>
        @endforeach
    </div>

    <!-- Offline Friends -->
    <h4 class="text-gray-400 font-semibold mt-4">⚪ Hors ligne</h4>
    <div class="space-y-2">
        @foreach($amisHorsLigne as $ami)
            <a href="#" class="flex items-center p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                <div class="relative h-12 w-12 rounded-full overflow-hidden border border-gray-300 dark:border-gray-600">
                    <img src="{{ $ami->profile_photo_url ? asset($ami->profile_photo_url) : 'https://via.placeholder.com/50' }}" 
                         alt="{{ $ami->pseudo }}" 
                         class="h-full w-full object-cover">
                    <span class="absolute bottom-1 right-1 block h-3.5 w-3.5 rounded-full bg-gray-400 border-2"></span>
                </div>
                <span class="ml-3 text-gray-900 dark:text-white font-medium">{{ $ami->pseudo }}</span>
            </a>
        @endforeach
    </div>

    <a href="{{ route('showallamis') }}" class="block text-indigo-500 hover:text-indigo-600 text-sm mt-3">Voir tous les amis</a>
</div>

        </div>
        <!-- Right Sidebar -->
        <div class="w-full md:w-80 bg-gray-800 bg-opacity-70 rounded-lg border border-gray-700 p-4 shadow overflow-y-auto h-auto md:h-screen">
            <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                <i class="fas fa-bell text-indigo-400 mr-2"></i> Activités Récentes
            </h2>
            <div class="space-y-4">
                <div class="flex items-start p-3 bg-gray-900 bg-opacity-50 rounded hover:bg-opacity-70 transition">
                    <div class="w-8 h-8 rounded-full overflow-hidden">
                        <img src="https://via.placeholder.com/50" alt="Activity" class="w-full h-full object-cover">
                    </div>
                    <div class="ml-2">
                        <p class="text-sm text-white"><span class="font-semibold">Marie Dupont</span> a partagé une publication</p>
                        <p class="text-xs text-gray-400">Il y a 20 minutes</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
