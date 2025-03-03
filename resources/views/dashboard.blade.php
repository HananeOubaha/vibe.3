<x-app-layout>
    <div class="min-h-screen  dark:bg-gray-900">
        <div class="flex mx-auto">
            <!-- Left Sidebar - Navigation -->
            <x-sidebar-left />
            <!-- Main Content - Posts Feed -->
            <div class="w-full md:w-3/2 md:ml-1/5 pt-4 px-4 sm:px-6 md:px-8">
                <div class="mt-2 bg-white dark:bg-gray-900 p-4 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 max-w-2xl mx-auto">
                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <img class="h-10 w-10 rounded-full object-cover border-2 border-indigo-500" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                @else
                                    <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <textarea
                                    name="contenu"
                                    rows="2"
                                    class="w-full p-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 transition duration-200 ease-in-out"
                                    placeholder="What's on your mind, {{ Auth::user()->name }}?"
                                ></textarea>
                                <div id="imagePreview" class="hidden mt-3 relative rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-800">
                                    <img id="preview" class="w-full max-h-40 object-contain" src="" alt="Preview">
                                    <button type="button" id="removeImage" class="absolute top-2 right-2 bg-gray-800 bg-opacity-70 text-white rounded-full p-1 hover:bg-opacity-100 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Action Bar -->
                                <div class="flex flex-wrap justify-between items-center mt-4 border-t border-gray-200 dark:border-gray-700 pt-3">
                                    <!-- Attachment Options -->
                                    <div class="flex items-center space-x-2 mb-2 sm:mb-0">
                                        <label for="image-upload" class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer transition group">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 group-hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">Photo</span>
                                        </label>
                                        <input
                                            id="image-upload"
                                            type="file"
                                            name="image"
                                            accept="image/*"
                                            class="hidden"
                                            onchange="previewImage(this)"
                                        >
                                    </div>

                                    <button
                                        type="submit"
                                        class="px-6 py-2 bg-indigo-500 hover:bg-indigo-700 text-white font-medium rounded-lg transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    >
                                        Post
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Posts Feed -->
                <div class="mt-6 mb-20 space-y-6 max-w-2xl mx-auto">
                    @foreach($posts as $post)
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md relative border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-lg" x-data="{ showComments: false }">
                            <!-- Post Header with User Info -->
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center ">
                                    <a href="{{ route('profil.show', ['userId' => $post->auteur->id]) }}" class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full object-cover border-2 border-indigo-500 transition-transform duration-300 hover:scale-105"
                                             src="{{ $post->auteur->profile_photo_url ?? asset('img/default-avatar.png') }}"
                                             alt="{{ $post->auteur?->name ?? 'Utilisateur inconnu' }}">
                                    </a>
                                    <div class="ml-3">
                                        <a href="{{ route('profil.show', ['userId' => $post->auteur->id]) }}" class="font-medium text-gray-900 dark:text-white">{{ $post->auteur->pseudo }}</a>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                <!-- Three-dot menu for post options -->
                                @if(auth()->user()->id === $post->auteur_id)
                                    <div x-data="{ open: false, editModal: false }" class="relative">
                                        <button @click="open = !open" class="p-1 rounded-md text-gray-300 font-bold">
                                            ⋮
                                        </button>

                                        <div x-show="open"
                                             @click.away="if (!editModal) open = false"
                                             x-cloak
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="transform opacity-0 scale-95"
                                             x-transition:enter-end="transform opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-150"
                                             x-transition:leave-start="transform opacity-100 scale-100"
                                             x-transition:leave-end="transform opacity-0 scale-95"
                                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg z-10 border border-gray-200 dark:border-gray-600">
                                            <div class="py-1">
                                                <!-- Edit Button -->
                                                <button @click.stop="editModal = true; open = false"
                                                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 transition-colors duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Modifier
                                                </button>

                                                <!-- Delete Button -->
                                                <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="flex items-center w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900 transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div x-show="editModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">
                                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Modifier le post</h2>
                                                <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" >
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="flex items-start space-x-3">
                                                        <div class="flex-shrink-0">
                                                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                                                <img class="h-10 w-10 rounded-full object-cover border-2 border-indigo-500" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                                            @else
                                                                <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">
                                                                    {{ substr(Auth::user()->name, 0, 1) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow">
                                                            <textarea
                                                                name="contenu"
                                                                rows="2"
                                                                class="w-full p-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none text-gray-800 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 transition duration-200 ease-in-out"
                                                                placeholder="Modifier votre post"
                                                            >{{ $post->contenu }}</textarea>

                                                            <div id="imagePreview_edit" class="mt-3 relative rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-800 {{ $post->image ? '' : 'hidden' }}">
                                                                <img id="preview_edit" class="w-full max-h-40 object-contain" src="{{ $post->image ? asset('storage/'.$post->image) : '' }}" alt="Preview">
                                                                <button type="button" id="removeImage" class="absolute top-2 right-2 bg-gray-800 bg-opacity-70 text-white rounded-full p-1 hover:bg-opacity-100 transition">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                    </svg>
                                                                </button>
                                                            </div>

                                                            <div class="flex flex-wrap justify-between items-center mt-4 border-t border-gray-200 dark:border-gray-700 pt-3">
                                                                <div class="flex items-center space-x-2 mb-2 sm:mb-0">
                                                                    <label for="image_upload_edit" class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer transition group">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 group-hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                        </svg>
                                                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">Photo</span>
                                                                    </label>
                                                                    <input
                                                                        id="image_upload_edit"
                                                                        type="file"
                                                                        name="image"
                                                                        accept="image/*"
                                                                        class="hidden"
                                                                        onchange="previewImageupdate(this)"
                                                                    >
                                                                </div>

                                                                <div class="flex justify-end space-x-2">
                                                                    <button @click="editModal = false" type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                                                                        Annuler
                                                                    </button>
                                                                    <button type="submit" name="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                                                                        Sauvegarder
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                    </div>
                                @endif


                            </div>

                            <p class="text-gray-800 dark:text-gray-200 mb-3">{{ $post->contenu }}</p>
                            @if($post->image)
                                <div class="rounded-lg overflow-hidden mb-3 transition-transform duration-300 hover:scale-[1.02]">
                                    <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-auto max-h-96 object-contain" alt="Post image">
                                </div>
                            @endif

                            <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                                <!-- Bouton Like avec compteur -->
                                <form action="{{ route('likePost', $post->id) }}" method="post">
                                    @csrf
                                    <button class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                        </svg>
                                        <span>Like ({{ $post->likes->count() }})</span>
                                    </button>
                                </form>

                                <!-- Bouton Commentaire avec compteur -->
                                <button @click="showComments = !showComments" class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <span>Comment ({{ $post->comments->count() }})</span>
                                </button>

                                <!-- Bouton Partage avec compteur -->
                                <button class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                    </svg>
{{--                                  <span>Share ({{ $post->shares->count() }})</span>--}}
                                </button>
                            </div>


                            <!-- Comments Section (toggles visibility when Comment button is clicked) -->
                            <div x-show="showComments"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform -translate-y-4"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-4"
                                 class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">

                                <!-- Existing Comments -->
                                <div class="mb-4 space-y-3">
                                    @forelse($post->comments  as $comment)
                                        <div class="flex items-start space-x-3">
                                            <img class="h-8 w-8 rounded-full object-cover" src="{{ $comment->user->profile_photo_url ?? asset('img/default-avatar.png') }}" alt="{{ $comment->user->name ?? 'Utilisateur' }}">
                                            <div class="flex-1 bg-gray-100 dark:bg-gray-700 rounded-lg p-3">
                                                <div class="flex justify-between items-center mb-1">
                                                    <p class="font-medium text-sm text-gray-900 dark:text-white">{{ $comment->user->pseudo ?? 'Utilisateur' }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() ?? 'À l\'instant' }}</p>
                                                </div>
                                                <p class="text-sm text-gray-800 dark:text-gray-200">{{ $comment->contenu ?? 'Contenu du commentaire' }}</p>
                                                <div class="flex mt-2 space-x-3 text-xs">
                                                    <button class="text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors duration-200">J'aime</button>
                                                    <button class="text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors duration-200">Répondre</button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">Aucun commentaire pour l'instant. Soyez le premier à commenter!</p>
                                    @endforelse
                                </div>

                                <!-- New Comment Form -->
                                <form class="flex items-start space-x-3 relative" method="post" action="{{ route('commentaires.store') }}">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                         src="{{ auth()->user()->profile_photo_url ?? asset('img/default-avatar.png') }}"
                                         alt="{{ auth()->user()->name ?? 'Utilisateur' }}">
                                    <!-- Textarea Container -->
                                    <div class="flex-1 relative">
                                        <textarea rows="1" name="contenu"
                                                  class="w-full px-3 py-2 bg-gray-700 border border-gray-600
                                                   rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                                   overflow-hidden resize-none transition-all duration-200 placeholder-gray-400 pr-10"
                                                  placeholder="Écrire un commentaire..."
                                                  x-data="{
                                                resize() {
                                                    $el.style.height = '38px';
                                                    $el.style.borderRadius = '9999px';
                                                    if ($el.scrollHeight > 38) {
                                                        $el.style.height = Math.min($el.scrollHeight, 150) + 'px'; // Limits max height
                                                        $el.style.borderRadius = '1rem';
                                                    }
                                                }
                                            }"
                                                  x-init="resize()"
                                                  @input="resize()"
                                                  @focus="resize()">
                                        </textarea>

                                        <!-- Comment Send Icon -->
                                        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-indigo-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Sidebar - Contacts & Friend Requests -->
            <div class="hidden lg:block w-1/5 fixed right-0 h-screen pt-2 pb-4 px-2 overflow-y-auto bg-white dark:bg-gray-900 border-l border-gray-200 dark:border-gray-800">
                <!-- Friend Requests Section -->
                <div class="py-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Friend Requests</h3>
                    @if($demandesRecues->isEmpty())
                        <div class="p-12 text-center">
                            <div class="relative">
{{--                                <div class="text-8xl mb-4 animate-bounce">🤝</div>--}}
                                <div class="absolute -inset-4 bg-gradient-to-r from-pink-400 via-purple-400 to-indigo-400 opacity-20 blur-3xl -z-10"></div>
                            </div>
                            <p class="text-gray-400 font-medium">No incoming friend requests at the moment</p>
                        </div>
                    @else
                        <div class="space-y-2 ">
                            @foreach($demandesRecues as $demande)
                                <div class="py-4 rounded-2xl hover:bg-gradient-to-br  hover:to-indigo-50
                                        transition-all duration-300 group/item mt-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <div class="relative">
                                                <img src="{{ $demande->demandeur->profile_photo_url }}"
                                                     class="w-11 h-11 rounded-2xl object-cover transition-all duration-300
                                                         group-hover/item:rounded-full group-hover/item:rotate-2">
                                            </div>
                                            <div>

                                                <h3 class="font-bold text-gray-400 text-lg">{{ $demande->demandeur->pseudo }}</h3>

                                                <p class="text-sm font-medium text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-purple-400">
                                                    @ {{ strtolower($demande->demandeur->name . $demande->demandeur->prenom) }}
                                                </p>

                                            </div>
                                        </div>
                                        <form action="{{ route('accepterDemandeAmitie', $demande->id) }}" method="post">
                                            @csrf
                                            <button class="flex items-center gap-2 px-2 py-2 text-sm font-bold text-green-600 bg-green-100  rounded-xl
                                                    ">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>

                                            </button>
                                        </form>
                                        <form action="{{ route('refuserDemandeAmitie', $demande->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="flex items-center gap-2 px-2 py-2 text-sm font-bold text-red-600 bg-red-100  rounded-xl
                                                    ">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <a href="{{ route('afficherDemandesAmitie') }}" class="block text-indigo-500 hover:text-indigo-600 text-sm mt-3">See all requests</a>
                </div>


                <!-- Contacts Section -->
                <!-- Contacts Section -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-800">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Contacts</h3>
                    <div class="space-y-2">
                        @foreach($amis as $ami)
                            <a href="#" class="flex items-center p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                                <div class="relative h-12 w-12 rounded-full overflow-hidden border border-gray-300 dark:border-gray-600">
                                    @if($ami->profile_photo_url)
                                        <img src="{{ asset($ami->profile_photo_url) }}" alt="{{ $ami->name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full bg-gray-300 dark:bg-gray-600"></div>
                                    @endif
                                    <!-- Statut en ligne -->
                                    <span class="absolute bottom-1 right-1 block h-3.5 w-3.5 rounded-full
                                        {{ $ami->isOnline() ? 'bg-green-500' : 'bg-gray-400' }} border-2 ">
                                     </span>
                                </div>
                                <span class="ml-3 text-gray-900 dark:text-white font-medium">{{ $ami->pseudo }}</span>
                            </a>

                        @endforeach
                    </div>
                    <a href="{{ route('showallamis') }}" class="block text-indigo-500 hover:text-indigo-600 text-sm mt-3">See all friends</a>
                </div>



            </div>
        </div>
    </div>

    <!-- Mobile Navigation Bar (Facebook-style) - Fixed at Bottom -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 flex justify-around p-2 z-50">
        <a href="{{ route('posts.index') }}" class="flex flex-col items-center p-2 text-indigo-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-xs">Home</span>
        </a>
        <a href="{{ route('showallamis') }}" class="flex flex-col items-center p-2 text-gray-500 dark:text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span class="text-xs">Friends</span>
        </a>
        <a href="{{ route('afficherDemandesAmitie') }}" class="flex flex-col items-center p-2 text-gray-500 dark:text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <span class="text-xs">Requests</span>
        </a>
        <a href="{{ route('profile.show') }}" class="flex flex-col items-center p-2 text-gray-500 dark:text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="text-xs">Settings</span>
        </a>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');
            const removeButton = document.getElementById('removeImage');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            }

            removeButton.addEventListener('click', function() {
                input.value = '';
                previewContainer.classList.add('hidden');
                preview.src = '';
            });
        }

    <!-- Dark Mode Toggle Script -->
        // Check for saved dark mode preference or use user's system preference
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Function to toggle dark mode
        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>
    <script>
        function previewImageupdate(input) {
            const preview = document.getElementById('preview_edit');
            const imagePreview = document.getElementById('imagePreview_edit');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.getElementById('removeImage_edit').addEventListener('click', function() {
            document.getElementById('preview_edit').src = '';
            document.getElementById('imagePreview_edit').classList.add('hidden');
            document.getElementById('image-upload_edit').value = '';
        });
    </script>

</x-app-layout>
