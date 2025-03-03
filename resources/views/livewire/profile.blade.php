<div class="max-w-2xl mx-auto bg-gray-100 dark:bg-gray-900 min-h-full">
    <!-- Profil header -->
    <div class="bg-indigo-600 dark:bg-indigo-900 rounded-b-xl shadow-lg relative overflow-hidden">
        <!-- Cover image -->
        <div class="h-32 bg-gradient-to-r from-indigo-800 to-indigo-600 dark:from-indigo-900 dark:to-indigo-700"></div>

        <!-- Profile info with avatar -->
        <div class="px-6 pb-5 -mt-12 relative">
            <div class="flex flex-col sm:flex-row sm:items-end">
                <!-- Avatar -->
                <div class="mx-auto sm:mx-0 h-24 w-24 rounded-full border-4 border-white dark:border-gray-800 overflow-hidden shadow-lg">
                    <img class="h-full w-full object-cover"
                         src="{{ $user->profile_photo_url ?? asset('img/default-avatar.png') }}"
                         alt="{{ $user?->name ?? 'Utilisateur inconnu' }}">

                </div>

                <!-- User info -->
                <div class="mt-3 sm:ml-4 text-center sm:text-left">
                    <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
                    <p class="text-indigo-200 dark:text-indigo-300">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation tabs -->
        <div class="flex px-6 py-2 bg-white dark:bg-gray-800 border-t border-indigo-100 dark:border-gray-700">
            <div class="flex space-x-4">
                <span class="font-medium text-indigo-600 dark:text-indigo-400 border-b-2 border-indigo-600 dark:border-indigo-400 px-1 py-2">Publications</span>
                <span class="text-gray-500 dark:text-gray-400 px-1 py-2 hover:text-indigo-600 dark:hover:text-indigo-400 transition duration-200">Photos</span>
                <span class="text-gray-500 dark:text-gray-400 px-1 py-2 hover:text-indigo-600 dark:hover:text-indigo-400 transition duration-200">À propos</span>
            </div>
        </div>
    </div>

    <!-- Post creation -->
{{--    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 mx-4 mt-4 border border-gray-200 dark:border-gray-700">--}}
{{--        <div class="flex items-center space-x-3">--}}
{{--            <img class="h-10 w-10 rounded-full object-cover border-2 border-indigo-500"--}}
{{--            <img class="h-10 w-10 rounded-full object-cover border-2 border-indigo-500 transition-transform duration-300 hover:scale-105"--}}
{{--                 src="{{ $user->profile_photo_url ?? asset('img/default-avatar.png') }}"--}}
{{--                 alt="{{ $user?->name ?? 'Utilisateur inconnu' }}">--}}
{{--               --}}
{{--            <div class="flex-1">--}}
{{--                <input type="text"--}}
{{--                       class="w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-full border-0 focus:ring-2 focus:ring-indigo-500 placeholder-gray-500 dark:placeholder-gray-400"--}}
{{--                       placeholder="Qu'avez-vous en tête?" />--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="flex mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 justify-between">--}}
{{--            <button class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors duration-200">--}}
{{--                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />--}}
{{--                </svg>--}}
{{--                <span>Photo</span>--}}
{{--            </button>--}}
{{--            <button class="px-4 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full font-medium transition duration-200">--}}
{{--                Publier--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Posts section -->
    <div class="mt-6 space-y-6 mx-4 ">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Publications</h2>

        @if($posts->isEmpty())
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md text-center border border-gray-200 dark:border-gray-700">
                <p class="text-gray-500 dark:text-gray-400">Cet utilisateur n'a encore publié aucun post.</p>
            </div>
        @else
            @foreach($posts as $post)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md relative border border-gray-200 dark:border-gray-700 transition-all duration-300 hover:shadow-lg" x-data="{ showComments: false }">
                    <!-- Post Header with User Info -->
                    <div class="flex items-center mb-3">
                        <a href="#" class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full object-cover border-2 border-indigo-500 transition-transform duration-300 hover:scale-105"
                                 src="{{ $user->profile_photo_url ?? asset('img/default-avatar.png') }}"
                                 alt="{{ $user?->name ?? 'Utilisateur inconnu' }}">
                        </a>
                        <div class="ml-3">
                            <a href="#" class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</a>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                        </div>

                        <!-- Three-dot menu for post options -->
{{--                        <div class="ml-auto relative" x-data="{ open: false }">--}}
{{--                            <button @click="open = !open" class="text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 focus:outline-none transition-colors duration-200">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">--}}
{{--                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />--}}
{{--                                </svg>--}}
{{--                            </button>--}}
{{--                            <div x-show="open"--}}
{{--                                 @click.away="open = false"--}}
{{--                                 x-transition:enter="transition ease-out duration-200"--}}
{{--                                 x-transition:enter-start="transform opacity-0 scale-95"--}}
{{--                                 x-transition:enter-end="transform opacity-100 scale-100"--}}
{{--                                 x-transition:leave="transition ease-in duration-150"--}}
{{--                                 x-transition:leave-start="transform opacity-100 scale-100"--}}
{{--                                 x-transition:leave-end="transform opacity-0 scale-95"--}}
{{--                                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg z-10 border border-gray-200 dark:border-gray-600">--}}
{{--                                <div class="py-1">--}}
{{--                                    <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 transition-colors duration-200">--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />--}}
{{--                                        </svg>--}}
{{--                                        Modifier--}}
{{--                                    </a>--}}
{{--                                    <form method="POST" action="#">--}}
{{--                                        @csrf--}}
{{--                                        @method('DELETE')--}}
{{--                                        <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900 transition-colors duration-200">--}}
{{--                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />--}}
{{--                                            </svg>--}}
{{--                                            Supprimer--}}
{{--                                        </button>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
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
                            <span>Comment ({{ $post->comments->count() ?? 0 }})</span>
                        </button>

                        <!-- Bouton Partage -->

                        <button class="flex items-center space-x-2 text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            <span>Share</span>
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
                            @forelse($post->comments ?? [] as $comment)
                                <div class="flex items-start space-x-3">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                                                                        src="{{ $post->auteur->profile_photo_url ?? asset('img/default-avatar.png') }}"
                                                                                        alt="{{ $post->auteur?->name ?? 'Utilisateur inconnu' }}">
                                    <div class="flex-1 bg-gray-100 dark:bg-gray-700 rounded-lg p-3">
                                        <div class="flex justify-between items-center mb-1">
                                            <p class="font-medium text-sm text-gray-900 dark:text-white">Utilisateur</p>
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
        @endif
    </div>
</div>
