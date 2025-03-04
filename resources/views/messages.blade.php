<x-app-layout>
    <div class="flex flex-col md:flex-row justify-between items-start min-h-screen gap-8 bg-gradient-to-br from-black to-indigo-950 text-white ">

        <!-- Sidebar Left -->
        <div class="w-full md:w-72">
            <x-sidebar-left />
        </div>

        <!-- Main Chat Section -->
        <div class="flex-1 container mx-auto p-5">
            <div class="grid grid-cols-4 gap-6 h-screen">

                <!-- Zone de chat -->
                <div class="col-span-3 bg-gray-900 p-4 rounded-lg shadow-md flex flex-col h-full">
                    <h2 class="text-lg font-semibold text-indigo-400 mb-3">Messages</h2>

                    <!-- Messages -->
                    <div class="flex-1 overflow-y-auto p-2 space-y-3">
                        <div class="flex justify-start">
                            <div class="bg-gray-700 p-3 rounded-lg max-w-xs">Salut, comment ça va ?</div>
                        </div>
                        <div class="flex justify-end">
                            <div class="bg-indigo-600 text-white p-3 rounded-lg max-w-xs">Ça va bien et toi ?</div>
                        </div>
                    </div>

                    <!-- Champ d'envoi de message (fixé en bas) -->
                    <!-- Champ d'envoi de message (fixé en bas) -->
                    <div class="border-t border-gray-700 p-3 flex items-center space-x-2 bg-gray-900 sticky bottom-0">
                        <!-- Bouton pour attacher un fichier -->
                        <label for="fileInput" class="cursor-pointer p-2 bg-gray-800 text-gray-400 rounded-lg hover:bg-gray-700 transition">
                            <i class="fas fa-paperclip"></i>
                        </label>
                        <input type="file" id="fileInput" class="hidden">

                        <!-- Champ de texte -->
                        <input type="text" placeholder="Écrire un message..." class="w-full p-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-indigo-500">

                        <!-- Bouton envoyer -->
                        <button class="p-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>

                <!-- Liste des amis + Amis en ligne -->
                <div class="bg-gray-900 p-4 rounded-lg shadow-md h-full overflow-y-auto">
                    <h2 class="text-lg font-semibold text-green-400 mt-6 mb-3">Amis en ligne</h2>
                    <ul class="space-y-3">
                        <li class="p-2 bg-gray-800 rounded-lg hover:bg-gray-700 transition">
                            <a href="#" class="flex items-center space-x-3">
                                <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                <span class="text-white">Ami 3</span>
                            </a>
                        </li>

                    </ul>
                    <h2 class="text-lg font-semibold text-indigo-400 mb-3">Amis</h2>
                    <ul class="space-y-3">
                        <li class="p-2 bg-gray-800 rounded-lg hover:bg-gray-700 transition">
                            <a href="#" class="flex items-center space-x-3">
                                <img src="https://via.placeholder.com/40" class="w-10 h-10 rounded-full" alt="User">
                                <span class="text-white">Ami 1</span>
                            </a>
                        </li>
                        <li class="p-2 bg-gray-800 rounded-lg hover:bg-gray-700 transition">
                            <a href="#" class="flex items-center space-x-3">
                                <img src="https://via.placeholder.com/40" class="w-10 h-10 rounded-full" alt="User">
                                <span class="text-white">Ami 2</span>
                            </a>
                        </li>
                    </ul>


                </div>

            </div>
        </div>

    </div>
</x-app-layout>
