<x-app-layout >
    <div class="flex">
        <x-sidebar-left />


    <div class="md:max-w-7xl max-w-5xl mx-auto px-4 md:pl-40 py-8">
        <!-- Animated Wave Separator -->
        <div class="w-full h-2 bg-gradient-to-r from-pink-800 via-purple-400 to-indigo-400 rounded-full mb-8"></div>

        <!-- Demandes Container -->
        <div class="grid grid-cols- md:grid-cols-2 gap-8">
            <!-- Demandes Envoyées -->
            <div class="group">
                <div class="bg-balck rounded-3xl shadow-2xl overflow-hidden border border-purple-100
                           transition-all duration-500 hover:shadow-purple-200/50 hover:-translate-y-1">
                    <div class="bg-gradient-to-br from-pink-50 via-purple-50 to-indigo-50 p-6">
                        <h2 class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-purple-500
                                 flex items-center gap-3">
                            <span class="text-3xl">📤</span>
                            Demandes envoyées
                        </h2>
                    </div>

                    @if($demandesEnvoyees->isEmpty())
                        <div class="p-12 text-center">
                            <div class="relative">
                                <div class="text-8xl mb-4 animate-bounce">🤝</div>
                                <div class="absolute -inset-4 bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400 opacity-20 blur-3xl -z-10"></div>
                            </div>
                            <p class="text-gray-400 font-medium">Aucune demande envoyée pour le moment</p>
                        </div>
                    @else
                        <div class="space-y-2 px-4">
                            @foreach($demandesEnvoyees as $demande)
                                <div class="py-4 rounded-2xl hover:bg-gradient-to-br  hover:from-pink-50 hover:via-purple-50 hover:to-indigo-50
                                          transition-all duration-300 group/item mt-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="relative">
                                                <img src="{{ $demande->receveur->profile_photo_url }}"
                                                     class="w-16 h-16 rounded-2xl object-cover transition-all duration-300
                                                            group-hover/item:rounded-full group-hover/item:rotate-2">
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-400  text-lg">{{ $demande->receveur->pseudo }}</h3>
                                                <p class="text-sm font-medium text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-purple-400">
                                                    @ {{ strtolower($demande->receveur->name . $demande->receveur->prenom) }}
                                                </p>
                                            </div>
                                        </div>
                                            <form action="{{ route('AnnulerDemandeAmitie',$demande->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-6 py-3 text-sm font-bold text-purple-600 bg-purple-100 rounded-xl
                                                         hover:bg-purple-200 hover:scale-105 hover:-rotate-1 transition-all duration-300">
                                                    Annuler
                                                </button>
                                            </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Demandes Reçues -->
            <div class="group">
                <div class="bg-gray-900 rounded-3xl shadow-2xl overflow-hidden border border-indigo-100
                           transition-all duration-500 hover:shadow-indigo-200/50 hover:-translate-y-1">
                    <div class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 p-6">
                        <h2 class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-500
                                 flex items-center gap-3">
                            <span class="text-3xl">📥</span>
                            Demandes reçues
                        </h2>
                    </div>

                    @if($demandesRecues->isEmpty())
                        <div class="p-12 text-center">
                            <div class="relative">
                                <div class="text-8xl mb-4 animate-bounce">📭</div>
                                <div class="absolute -inset-4 bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 opacity-20 blur-3xl -z-10"></div>
                            </div>
                            <p class="text-gray-400 font-medium">Aucune demande reçue pour le moment</p>
                        </div>
                    @else
                        <div class="space-y-2 px-4">
                            @foreach($demandesRecues as $demande)
                                <div class="py-4 rounded-2xl hover:bg-gradient-to-br hover:from-indigo-50 hover:via-purple-50 hover:to-pink-50
                                          transition-all duration-300 group/item mt-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="relative">
                                                <img src="{{ $demande->demandeur->profile_photo_url }}"
                                                     class="w-16 h-16 rounded-2xl object-cover transition-all duration-300
                                                            group-hover/item:rounded-full group-hover/item:rotate-2">

                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-400 text-lg">{{ $demande->demandeur->pseudo }}</h3>
                                                <p class="text-sm font-medium text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">
                                                    @ {{ strtolower($demande->demandeur->name . $demande->demandeur->prenom) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex gap-3 px-4">
                                            <form method="POST" action="{{ route('accepterDemandeAmitie', $demande->id) }}">
                                                @csrf
                                                <button class="px-6 py-3 text-sm font-bold text-white bg-indigo-600
                       rounded-xl hover:from-indigo-600 hover:to-purple-600 hover:scale-105 hover:rotate-1
                       transition-all duration-300 shadow-xl hover:shadow-purple-200">
                                                    <!-- Icon for Accept (check mark) -->
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('refuserDemandeAmitie', $demande->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-6 py-3 text-sm font-bold text-indigo-600 bg-indigo-100 rounded-xl
                       hover:bg-indigo-200 hover:scale-105 hover:-rotate-1 transition-all duration-300">
                                                    <!-- Icon for Reject (times) -->
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>


                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
    </div>
</x-app-layout>
