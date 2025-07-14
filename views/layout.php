<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'MyOCVerse'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/custom.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <nav class="bg-gray-800 shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-purple-400">
                        <i class="fas fa-magic mr-2"></i>MyOCVerse
                    </a>
                </div>
                
                <div class="hidden md:flex space-x-6">
                    <a href="/" class="hover:text-purple-400 transition">Accueil</a>
                    <a href="/community" class="hover:text-purple-400 transition">Communauté</a>
                    <a href="/leaderboard" class="hover:text-purple-400 transition">Classements</a>
                    <a href="/events" class="hover:text-purple-400 transition">Événements</a>
                    <a href="/search" class="hover:text-purple-400 transition">Recherche</a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="flex items-center space-x-2">
                            <span class="text-yellow-400">
                                <i class="fas fa-star"></i>
                                <?php 
                                $user = $this->getCurrentUser();
                                echo $user['xp'] ?? 0;
                                ?>
                            </span>
                            <span class="text-blue-400">
                                Niv. <?php echo getLevel($user['xp'] ?? 0); ?>
                            </span>
                        </div>
                        
                        <div class="relative group">
                            <button class="flex items-center space-x-2 hover:text-purple-400">
                                <i class="fas fa-user"></i>
                                <span><?php echo $_SESSION['username']; ?></span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            
                            <div class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <a href="/dashboard" class="block px-4 py-2 hover:bg-gray-700">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                                <a href="/oc/create" class="block px-4 py-2 hover:bg-gray-700">
                                    <i class="fas fa-plus mr-2"></i>Créer un OC
                                </a>
                                <a href="/universe/create" class="block px-4 py-2 hover:bg-gray-700">
                                    <i class="fas fa-globe mr-2"></i>Créer un Univers
                                </a>
                                <a href="/race/create" class="block px-4 py-2 hover:bg-gray-700">
                                    <i class="fas fa-dna mr-2"></i>Créer une Race
                                </a>
                                <hr class="border-gray-600">
                                <a href="/logout" class="block px-4 py-2 hover:bg-gray-700 text-red-400">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/login" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded transition">
                            Connexion
                        </a>
                        <a href="/register" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded transition">
                            Inscription
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        <?php echo $content; ?>
    </main>

    <footer class="bg-gray-800 mt-16 py-8">
        <div class="container mx-auto px-4 text-center text-gray-400">
            <p>&copy; 2024 MyOCVerse. Créé avec passion pour la communauté des créateurs.</p>
        </div>
    </footer>

    <script src="/assets/js/app.js"></script>
</body>
</html>