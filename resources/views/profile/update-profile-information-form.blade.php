
<div class="min-h-screen bg-gray-950 text-white">
        <!-- Profile Cover & Header -->
        <div class="bg-gradient-to-r from-indigo-900/40 to-gray-900 rounded-t-lg h-48 relative overflow-hidden mt- max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="absolute bottom-0 left-0 w-full p-4 flex items-end space-x-4">
                <div class="relative">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="w-32 h-32 rounded-full border-4 border-indigo-600 bg-gray-800 shadow-xl object-cover" />
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <label for="photo" class="absolute bottom-0 right-0 bg-indigo-600 hover:bg-indigo-700 rounded-full p-2 shadow-lg cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <input type="file" id="photo" class="hidden" wire:model.live="photo" />
                        </label>
                    @endif
                </div>
                <div class="pb-2">
                    <h1 class="text-2xl font-bold text-white">{{ $this->user->pseudo ?? $this->user->name }}</h1>
                    <p class="text-indigo-300">{{ '@' . ($this->user->prenom .' '. $this->user->name) }}</p>
                </div>
            </div>
        </div>

        <!-- Profile Tabs -->
        <div class="bg-gray-900 border-b border-indigo-900/40 rounded-b-lg shadow-lg mb-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex border-t border-indigo-900/20">
                <button class="px-4 py-3 font-medium text-indigo-400 border-b-2 border-indigo-500">Posts</button>
                <button class="px-4 py-3 font-medium text-gray-400 hover:text-indigo-300 transition">About</button>
                <button class="px-4 py-3 font-medium text-gray-400 hover:text-indigo-300 transition">Friends</button>
                <button class="px-4 py-3 font-medium text-gray-400 hover:text-indigo-300 transition">Photos</button>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Sidebar - Profile Information Form -->
                <div class="md:col-span-1">
                    <div class="bg-gray-900 rounded-lg shadow-xl p-6 border border-indigo-500/20 mb-6 sticky top-20">
                        <form wire:submit="updateProfileInformation">
                            <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                                <span>{{ __('Profile Information') }}</span>
                                <button type="submit" class="ml-auto text-indigo-400 hover:text-indigo-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                            </h2>

                            <div class="space-y-4">
                                <!-- Hidden File Input -->
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <div x-data="{photoName: null, photoPreview: null}" class="hidden">
                                        <input type="file" id="photo" class="hidden"
                                               wire:model.live="photo"
                                               x-ref="photo"
                                               x-on:change="
                                                photoName = $refs.photo.files[0].name;
                                                const reader = new FileReader();
                                                reader.onload = (e) => {
                                                    photoPreview = e.target.result;
                                                };
                                                reader.readAsDataURL($refs.photo.files[0]);
                                            " />
                                    </div>
                                    <x-input-error for="photo" class="mt-2 text-red-400" />
                                @endif

                                <!-- Bio -->
                                <div>
                                    <h3 class="text-indigo-300 font-medium">{{ __('Bio') }}</h3>
                                    <textarea id="bio" class="w-full bg-gray-800 border-gray-700 focus:border-indigo-500 text-white rounded-md shadow-sm mt-1 border-none" wire:model="state.bio" rows="3"></textarea>
                                </div>

                                <!-- Pseudo Name -->
                                <div>
                                    <h3 class="text-indigo-300 font-medium">{{ __('Pseudo Name') }}</h3>
                                    <input id="pseudo" type="text" class="w-full bg-gray-800 border-gray-700 focus:border-indigo-500 text-white rounded-md shadow-sm mt-1" wire:model="state.pseudo" required />
                                    <x-input-error for="pseudo" class="mt-2 text-red-400" />
                                </div>

                                <!-- Name -->
                                <div>
                                    <h3 class="text-indigo-300 font-medium">{{ __('Name') }}</h3>
                                    <input id="name" type="text" class="w-full bg-gray-800 border-gray-700 focus:border-indigo-500 text-white rounded-md shadow-sm mt-1" wire:model="state.name" required />
                                    <x-input-error for="name" class="mt-2 text-red-400" />
                                </div>

                                <!-- Prenom -->
                                <div>
                                    <h3 class="text-indigo-300 font-medium">{{ __('Prenom') }}</h3>
                                    <input id="prenom" type="text" class="w-full bg-gray-800 border-gray-700 focus:border-indigo-500 text-white rounded-md shadow-sm mt-1" wire:model="state.prenom" required />
                                    <x-input-error for="prenom" class="mt-2 text-red-400" />
                                </div>
                                <!-- Email -->
                                <div>
                                    <h3 class="text-indigo-300 font-medium">{{ __('Email') }}</h3>
                                    <input id="email" type="email" class="w-full bg-gray-800 border-gray-700 focus:border-indigo-500 text-white rounded-md shadow-sm mt-1" wire:model="state.email" required />
                                    <x-input-error for="email" class="mt-2 text-red-400" />

                                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                                        <p class="text-sm mt-2 text-gray-400">
                                            {{ __('Your email address is unverified.') }}

                                            <button type="button" class="underline text-sm text-indigo-400 hover:text-indigo-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:click.prevent="sendEmailVerification">
                                                {{ __('Click here to re-send the verification email.') }}
                                            </button>
                                        </p>

                                        @if ($this->verificationLinkSent)
                                            <p class="mt-2 font-medium text-sm text-green-500">
                                                {{ __('A new verification link has been sent to your email address.') }}
                                            </p>
                                        @endif
                                    @endif
                                </div>
                                <!-- Save Button -->
                                <div class="pt-4 flex items-center">
                                    <x-action-message class="mr-3 text-indigo-400" on="saved">
                                        {{ __('Saved.') }}
                                    </x-action-message>

                                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow-md transition" wire:loading.attr="disabled" wire:target="photo">
                                        {{ __('Save Changes') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Main Content - Posts -->
                <div class="md:col-span-2">
                    <!-- Create Post -->
                    <div class="bg-gray-900 rounded-lg shadow-xl p-6 border border-indigo-500/20 mb-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="w-10 h-10 rounded-full border border-indigo-600 object-cover" />
                            <a href="{{ route('posts.store') }}" class="bg-gray-800 rounded-full py-2 px-4 flex-grow border border-gray-700 hover:border-indigo-500 cursor-pointer transition text-gray-400">
                                {{ __("What's on your mind?") }}
                            </a>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-indigo-900/20">
                            <a href="{{ route('posts.store') }}" class="flex items-center text-gray-400 hover:text-indigo-400 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ __('Photo') }}
                            </a>
                            <a href="{{ route('posts.store') }}" class="flex items-center text-gray-400 hover:text-indigo-400 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                {{ __('Video') }}
                            </a>
                            <a href="{{ route('posts.store') }}" class="flex items-center text-gray-400 hover:text-indigo-400 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                {{ __('Create Post') }}
                            </a>
                        </div>
                    </div>
                    <!-- Posts -->


                    <div class="space-y-6">
                                        @forelse($posts ?? [] as $post)
                                            <div class="bg-gray-900 rounded-lg shadow-xl border border-indigo-500/20 overflow-hidden">
                                                <div class="p-4">
                                                <div class="flex items-center space-x-3 mb-3">
                                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="w-10 h-10 rounded-full border border-indigo-600 object-cover" />
                                        <div>
                                            <h3 class="font-semibold text-white">{{ $this->user->pseudo ?? $this->user->name }}</h3>
                                            <p class="text-xs text-indigo-400">{{ $post->created_at->diffForHumans() }}</p>
                                        </div>
                                        <button class="ml-auto text-gray-400 hover:text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <h2 class="text-xl font-semibold text-white mb-2">{{ $post->title }}</h2>
                                    <p class="text-gray-300 mb-4">{{ $post->excerpt }}</p>

                                    @if(isset($post->image))
                                        <img src="{{ $post->image }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-lg mb-4" />
                                    @endif

                                    <div class="flex justify-between items-center pt-3 border-t border-indigo-900/20">
                                        <div class="flex space-x-4">
                                            <button class="flex items-center text-gray-400 hover:text-indigo-400 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                                </svg>
                                                {{ __('Like') }}
                                            </button>
                                            <button class="flex items-center text-gray-400 hover:text-indigo-400 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                                </svg>
                                                {{ __('Comment') }}
                                            </button>
                                            <button class="flex items-center text-gray-400 hover:text-indigo-400 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                                </svg>
                                                {{ __('Share') }}
                                            </button>
                                        </div>
                                        <div class="flex items-center">
                                            <a href="{{ route('posts.edit', $post) }}" class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-md shadow transition mr-2">
                                                {{ __('Edit') }}
                                            </a>
                                            <button wire:click="deletePost({{ $post->id }})" class="px-3 py-1 bg-gray-700 hover:bg-red-700 text-white text-sm rounded-md shadow transition">
                                                {{ __('Delete') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-gray-900 rounded-lg shadow-xl border border-indigo-500/20 p-8 text-center">
                                <div class="text-indigo-500 mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <p class="text-gray-400 mb-6">{{ __('No posts yet.') }}</p>
                                <a href="{{ route('posts.store') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow-md transition">
                                    {{ __('Create Your First Post') }}
                                </a>
                            </div>
                        @endforelse

                        @if(!empty($posts ?? []))
                            <div class="text-center mt-8">
                                <a href="{{ route('posts.store') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md shadow-md transition inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    {{ __('Create New Post') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

