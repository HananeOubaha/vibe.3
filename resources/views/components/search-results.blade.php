<div class="flex">
    <form id="searchForm" class="relative w-46 py-3 px-4">
        <div class="flex items-center bg-gray-900 rounded-full px-4 py-1 shadow-md border border-indigo-500">
            <button type="submit" class="text-indigo-400 hover:text-indigo-300 transition">
                <i class="fas fa-search"></i>
            </button>
            <input type="text" id="searchInput" name="query" placeholder="Rechercher un ami..."
                   class="bg-transparent flex-1 h-9 pl-2 text-sm border-none w-full focus:outline-none text-white placeholder-indigo-300">
        </div>

        <div id="searchResults" class="absolute left-0 top-full mt-2 w-full bg-black rounded-lg shadow-lg overflow-hidden z-50 border border-indigo-500 p-3 hidden">
            <button id="closeResults" class="absolute top-2 right-2 text-indigo-400 hover:text-indigo-300 transition">
                <i class="fas fa-times"></i>
            </button>

            <div id="resultsContent" class="mt-6">
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById("searchForm").addEventListener("submit", function(event) {
        event.preventDefault();
        let query = document.getElementById("searchInput").value;

        fetch("{{ route('Search') }}?query=" + encodeURIComponent(query))
            .then(response => response.json())
            .then(users => {
                let resultsContainer = document.getElementById("resultsContent");
                resultsContainer.innerHTML = "";
                let searchResults = document.getElementById("searchResults");

                if (users.length > 0) {
                    users.forEach(user => {
                        let userElement = document.createElement("a");
                        userElement.href = "{{ route('profil.show', ['userId' => ':id']) }}".replace(':id', user.id);
                        userElement.classList.add("flex", "items-center", "gap-2", "px-2", "hover:bg-indigo-900", "rounded", "text-white", "mb-2");
                        userElement.innerHTML = `
                        <div class="w-8 h-8 bg-indigo-800 rounded-full overflow-hidden">
                            <img src="${user.profile_photo_url ?? '/default-avatar.png'}" alt="" class="w-full h-full object-cover">
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex flex-col">
                             <p class="font-medium text-white">${user.pseudo}</p>
                               <p class="text-xs text-indigo-300">${user.email}</p>
                            </div>
                                <form action="${envoyerDemandeAmitieRoute(user.id)}" method="post">
                                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  <button class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-700 hover:bg-indigo-600 text-white transition-colors">
                                     <i class="fas fa-user-plus"></i>
                                  </button>
                                </form>

                        </div>

                    `;
                        resultsContainer.appendChild(userElement);
                    });

                    searchResults.classList.remove("hidden");
                } else {
                    resultsContainer.innerHTML = "<p class='text-indigo-300 text-center'>Aucun utilisateur trouvé.</p>";
                    searchResults.classList.remove("hidden");
                }
            })
            .catch(error => console.error("Erreur lors de la recherche :", error));
    });
    function envoyerDemandeAmitieRoute(userId) {
        return `{{ route('envoyerDemandeAmitie', ':utilisateur_recepteur_id') }}`.replace(':utilisateur_recepteur_id', userId);
    }

    document.getElementById("closeResults").addEventListener("click", function() {
        document.getElementById("searchResults").classList.add("hidden");
    });

    document.addEventListener("click", function(event) {
        const searchForm = document.getElementById("searchForm");
        const searchResults = document.getElementById("searchResults");

        if (!searchForm.contains(event.target) && !searchResults.classList.contains("hidden")) {
            searchResults.classList.add("hidden");
        }
    });
</script>
