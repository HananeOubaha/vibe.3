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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($amis as $ami)
                    <div class="bg-gray-800 bg-opacity-70 rounded-lg shadow-lg hover:shadow-indigo-500/30 transition-all duration-300 transform hover:-translate-y-1 border border-gray-700">
                        <!-- Profile photo -->
                        <div class="pt-4 flex justify-center">
                            <a href="{{ route('profil.show', ['userId' => $ami->id]) }}" class="relative">
                                <div class="relative w-24 h-24 rounded-full border-4 border-gray-800 overflow-hidden mx-auto">
                                    <img src="{{ $ami->profile_photo_url ?? 'https://via.placeholder.com/50' }}" alt="Avatar" class="w-full h-full object-cover">
                                    <!-- Online Indicator -->
                                    <span class="absolute bottom-2 right-2 h-4 w-4 rounded-full ring-2 ring-gray-800 {{ $ami->isOnline() ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                </div>
                            </a>
                        </div>

                        <!-- Profile info -->
                        <div class="px-4 py-3 text-center">
                            <h3 class="text-xl font-bold text-white hover:text-indigo-300">
                                <a href="{{ route('profil.show', ['userId' => $ami->id]) }}">{{ $ami->pseudo }}</a>
                            </h3>
                            <a href="{{ route('profil.show', ['userId' => $ami->id]) }}" class="text-indigo-200 text-sm block">
                                {{ $ami->nom }} {{ $ami->prenom }}
                            </a>
                        </div>

                        <!-- Action buttons -->
                        <div class="px-4 pb-4">
                            <div class="grid grid-cols-2 gap-2">
                                <a href="#" class="flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-3 rounded-md text-sm font-medium">
                                    <i class="fas fa-comment-alt mr-1"></i> Message
                                </a>
                                <a href="{{ route('profil.show', ['userId' => $ami->id]) }}" class="flex items-center justify-center bg-gray-700 hover:bg-gray-600 text-white py-2 px-3 rounded-md text-sm font-medium">
                                    <i class="fas fa-user-friends mr-1"></i> Voir profil
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
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
