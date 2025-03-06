<x-app-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

                    <div  id="messages" class="flex-1 overflow-y-auto p-2 space-y-3">

                    </div>

                    <!-- Champ d'envoi de message (fixé en bas) -->
                    <!-- Champ d'envoi de message (fixé en bas) -->
                    <div class="border-t border-gray-700 p-3 flex items-center space-x-2 bg-gray-900 sticky bottom-0">
                        <!-- Bouton pour attacher un fichier -->
{{--                        <label for="fileInput" class="cursor-pointer p-2 bg-gray-800 text-gray-400 rounded-lg hover:bg-gray-700 transition">--}}
{{--                            <i class="fas fa-paperclip"></i>--}}
{{--                        </label>--}}
{{--                        <input type="file" id="fileInput" class="hidden">--}}

                        <!-- Champ de texte -->
                        <input type="text" name="message" id="message" placeholder="Écrire un message..." class="w-full p-2 bg-gray-800 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-indigo-500">

                        <!-- Bouton envoyer -->
                        <button id="send-message" class="p-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>

                <!-- Liste des amis + Amis en ligne -->
                <div class="bg-gray-900 p-4 rounded-lg shadow-md h-full overflow-y-auto">
                    <h2 class="text-lg font-semibold text-green-400 mt-6 mb-3">Amis en ligne</h2>
                    <ul class="space-y-3">
                        @forelse($users as $user)
                            @if($user->id !== Auth::id())
                            <li class="p-2 bg-gray-800 rounded-lg hover:bg-gray-700 transition">
                                <a href="#" class="flex items-center space-x-3">
                                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                    <span class="text-white select-user" data-id="{{ $user->id }}" >{{ $user->pseudo }}</span>
                                </a>
                            </li>
                            @endif
                        @empty
                            <p class="text-white">Aucun utilisateur</p>
                        @endforelse
                    </ul>

                    <h2 class="text-lg font-semibold text-indigo-400 mb-3">Amis</h2>
                    <ul class="space-y-3">
                        <li class="p-2 bg-gray-800 rounded-lg hover:bg-gray-700 transition">
                            <a href="#" class="flex items-center space-x-3">
                                <img src="https://placehold.co/40x40" class="w-10 h-10 rounded-full" alt="Avatar">
                                <span class="text-white">Ami 1</span>
                            </a>
                        </li>
                        <li class="p-2 bg-gray-800 rounded-lg hover:bg-gray-700 transition">
                            <a href="#" class="flex items-center space-x-3">
                                <img src="https://placehold.co/40x40" class="w-10 h-10 rounded-full" alt="Avatar">
                                <span class="text-white">Ami 2</span>
                            </a>
                        </li>
                    </ul>


                </div>

            </div>
        </div>

    </div>
    <script>

        window.Laravel = {!! json_encode(['user' => Auth::user()]) !!};

        document.addEventListener("DOMContentLoaded", function () {
            let selectedUserId = "";
            const messageInput = document.getElementById("message");
            const typingStatus = document.getElementById("typing-status");

            document.querySelectorAll(".select-user").forEach(user => {
                user.addEventListener("click", function () {
                    selectedUserId = this.getAttribute("data-id");
                    document.querySelectorAll(".select-user").forEach(u => u.classList.remove("bg-gray-700"));
                    this.classList.add("bg-gray-700");
                });
            });


            if (messageInput) {
                messageInput.addEventListener("input", function () {
                    if (selectedUserId) {
                        window.Echo.private(`typing.${selectedUserId}`)
                            .whisper('typing', {
                                user: window.Laravel.user.name
                            });
                    }
                });
            } else {
                console.error("L'élément #message n'existe pas dans le DOM.");
            }

            document.getElementById("send-message").addEventListener("click", function () {
                const message = messageInput.value.trim();
                if (message === "" || selectedUserId === "") {
                    alert("Veuillez entrer un message et choisir un destinataire.");
                    return;
                }

                fetch("{{ route('send-message') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").content
                    },
                    body: JSON.stringify({
                        message: message,
                        receiver_id: selectedUserId
                    })
                })
                    .then(response =>{
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            console.log(data) ;
                            messageInput.value = ""; // Clear the input
                            typingStatus.innerText = ""; // Reset typing status
                        } else {
                            console.error("Error:", data.message);
                        }
                    })
                    .catch(error => console.error("Erreur d'envoi :", error));
            });

            if (window.Laravel && window.Laravel.user) {
                window.Echo.private(`chat.${window.Laravel.user.id}`)
                    .listen('.MessageSent', (data) => {
                        let messagesDiv = document.getElementById("messages");
                        let newMessage = document.createElement("p");
                        newMessage.classList.add("p-2", "rounded-lg", "mb-2");

                        if (parseInt(data.user.id) === parseInt(window.Laravel.user.id)) {
                            newMessage.classList.add("bg-red-600", "text-white", "ml-auto", "w-fit", "p-2");
                            newMessage.innerHTML = `<strong>Moi :</strong> ${data.message}`;
                        } else {
                            newMessage.classList.add("bg-gray-700", "text-white", "mr-auto", "w-fit", "p-2");
                            newMessage.innerHTML = `<strong>${data.user.name} :</strong> ${data.message}`;
                        }

                        messagesDiv.appendChild(newMessage);
                        messagesDiv.scrollTop = messagesDiv.scrollHeight;
                    });

                window.Echo.private(`typing.${window.Laravel.user.id}`)
                    .listenForWhisper('typing', (data) => {
                        typingStatus.innerText = `${data.user} est en train d'écrire...`;
                        setTimeout(() => typingStatus.innerText = "", 2000);
                    });
            }
        });

        // pour les notification

        document.addEventListener("DOMContentLoaded", function () {
            if (typeof Echo !== "undefined" && window.Laravel?.user) {
                Echo.private(`chat.${window.Laravel.user.id}`)
                    .listen(".MessageSent", (data) => {
                        showNotification(`${data.user.name} vous a envoyé un message !`, data.message);
                    });
            }
        });

        function showNotification(title, message) {
            if (!("Notification" in window)) {
                alert("Les notifications ne sont pas supportées par votre navigateur.");
                return;
            }
            if (Notification.permission === "granted") {
                new Notification(title, { body: message });
            } else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(permission => {
                    if (permission === "granted") {
                        new Notification(title, { body: message });
                    }
                });
            }
        }
        document.addEventListener("DOMContentLoaded", function () {
            if (typeof Echo !== "undefined" && window.Laravel?.user) {
                Echo.private(`chat.${window.Laravel.user.id}`)
                    .listen(".MessageSent", (data) => {
                        showNotification(`${data.user.name} vous a envoyé un message !`, data.message);
                    });
            }
        });

        function showNotification(title, message) {
            let container = document.getElementById("notification-container");
            let notification = document.createElement("div");
            notification.classList.add(
                "bg-blue-500", "text-white", "p-3", "rounded-lg", "shadow-md",
                "mb-3", "animate-fade-in", "w-80"
            );
            notification.innerHTML = `<strong>${title}</strong><br>${message}`;

            container.appendChild(notification);

            // Supprime la notification après 5 secondes
            setTimeout(() => {
                notification.classList.add("animate-fade-out");
                setTimeout(() => notification.remove(), 500);
            }, 5000);
        }

    </script>
</x-app-layout>
