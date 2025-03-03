# Vibe Social - Extension de Fonctionnalités Sociales
![img.png](img.png)

## 📱 À propos

Vibe Social est une extension de l'application Vibe qui transforme la plateforme en un véritable réseau social. Cette nouvelle version permet aux utilisateurs d'ajouter des amis, de publier du contenu, d'interagir avec les publications des autres, et de profiter d'un fil d'actualités dynamique et interactif.

## ✨ Fonctionnalités

### Gestion des Relations
- **Système d'Amis** - Envoi, acceptation et refus de demandes d'amis
- **Liste d'Amis** - Affichage et gestion des connexions
- **Consultation de Profils** - Accès aux profils utilisateurs avec leurs publications et interactions

### Partage de Contenu
- **Publications** - Création de posts incluant texte et images
- **Modification et Suppression** - Gestion complète du contenu publié
- **Fil d'Actualités** - Affichage chronologique des publications des amis

### Interactions
- **Likes** - Ajout de likes aux publications avec compteur
- **Commentaires** - Possibilité de commenter les publications
- **Affichage Chronologique** - Tri des publications du plus récent au plus ancien

### Fonctionnalités Avancées (Bonus)
- **Notifications en Temps Réel** - Alertes pour les demandes d'amis et interactions
- **Système de Partage** - Diffusion des publications à travers le réseau
- **Pagination Infinie** - Chargement progressif du fil d'actualités
- **Hashtags** - Organisation et découverte de contenu via mots-clés

## 🚀 Installation

```bash
# Cloner le repository
git clone https://github.com/votre-username/vibe-social.git

# Se déplacer dans le répertoire
cd vibe-social

# Installer les dépendances PHP
composer install

# Installer les dépendances JavaScript
npm install

# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Configurer la base de données dans .env puis migrer
php artisan migrate

# Compiler les assets
npm run dev

# Démarrer le serveur de développement
php artisan serve
```

## 💻 Technologies Utilisées

- **Backend**: PHP 8.x, Laravel 10.x
- **Frontend**: Livewire, Alpine.js, Tailwind CSS
- **Base de données**: Postgresql
- **Temps réel**: Laravel Echo, Pusher
- **Authentification**: Laravel Fortify/Jetstream

## 📐 Architecture

Le projet suit l'architecture MVC de Laravel avec:
- **Models** - Définition des entités et relations
- **Controllers** - Logique métier
- **Views** - Templates Blade
- **Livewire Components** - Composants réactifs sans JavaScript complexe
- **Migrations** - Gestion de la structure de la base de données

## 🛠️ Développement

### Structure du Projet

```
vibe-social/
├── app/                        # Code de l'application
│   ├── Http/                   # Controllers, Middleware, Requests
│   │   ├── Controllers/        # Controllers Laravel
│   │   └── Livewire/           # Composants Livewire
│   ├── Models/                 # Modèles Eloquent
│   └── Providers/              # Service Providers
│
├── database/                   # Migrations et Seeds
│   ├── migrations/             # Migrations de base de données
│   └── seeders/                # Seeders pour les données initiales
│
├── resources/                  # Assets frontend
│   ├── css/                    # Fichiers CSS/SCSS
│   ├── js/                     # JavaScript
│   └── views/                  # Templates Blade et composants
│       ├── components/         # Composants Blade
│       ├── layouts/            # Layouts réutilisables
│       └── livewire/           # Templates de composants Livewire
│
├── routes/                     # Définition des routes
│   ├── web.php                 # Routes web
│   └── api.php                 # Routes API (si nécessaire)
│
└── README.md                   # Documentation
```

## 🔄 Temps Réel

Les fonctionnalités en temps réel sont implémentées avec:
- Laravel Echo pour le client JavaScript
- Laravel Websockets ou Pusher pour le backend
- Livewire pour les mises à jour automatiques de composants

## 🔐 Authentification et Autorisation

- Utilisation des policies Laravel pour gérer les permissions
- Gestion des rôles et droits d'accès par middleware
- Protection CSRF automatique via Laravel

## 📝 Contribution

1. Forker le projet
2. Créer une branche pour votre fonctionnalité (`git checkout -b feature/amazing-feature`)
3. Commiter vos changements (`git commit -m 'feat: Ajouter une fonctionnalité incroyable'`)
4. Pousser vers la branche (`git push origin feature/amazing-feature`)
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus d'informations.

## 👥 Équipe

- TBIBZAT CHARAF EDDINE - Chef de Projet & Développeur
