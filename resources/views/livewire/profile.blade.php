<div class="max-w-2xl mx-auto bg-gray-100 dark:bg-gray-900 min-h-full">
    <!-- Affichage des messages flash -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @endif

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

                <!-- Share Icon and QR Code -->
                <div class="ml-auto relative" x-data="{ openShare: false, qrCodeUrl: null, invitationLink: null }" x-init="invitationLink = '{{ $this->generateInvitationLink() }}';
                        qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + encodeURIComponent(invitationLink);">
                    <button @click="openShare = !openShare" class="text-gray-300 hover:text-white focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                    </button>

                    <!-- Share dropdown -->
                    <div x-show="openShare" @click.away="openShare = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-10 border border-gray-200 dark:border-gray-600">
                        <div class="py-1">
                            <a :href="invitationLink" target="_blank" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M15 8a3 3 0 10-2.977-2.63l.494-2.47a3 3 0 10-5.156 6.239l-1.203 6.018a3 3 0 103.953 5.374l-2.88-1.44a3 3 0 10-2.636-2.977l.494-2.47a3 3 0 105.156 6.239l1.203-6.018a3 3 0 10-3.953-5.374l2.88 1.44z" />
                                </svg>
                                Copier le lien
                            </a>
                            <a :href="qrCodeUrl" target="_blank" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-900 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm11 1H6v2h8V6zm1 4H6v2h9v-2z" clip-rule="evenodd" />
                                </svg>
                                Afficher le QR Code
                            </a>
                        </div>
                    </div>
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

    <!-- Posts section -->
    <div class="mt-6 space-y-6 mx-4 ">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Publications</h2>

        @if($posts->isEmpty())
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md text-center border border-gray-200 dark:border-gray-700">
                <p class="text-gray-500 dark:text-gray-400">Cet utilisateur n'a encore publié aucun post.</p>
            </div>
        @else
            @foreach($posts as $post)
               <!-- Post rendering code here -->
            @endforeach
        @endif
    </div>
</div>
