<?php
ob_start();
$title = "Accueil - MyOCVerse";
?>

<div class="hero-section bg-gradient-to-r from-purple-800 to-blue-800 rounded-lg p-8 mb-8">
    <div class="text-center">
        <h1 class="text-4xl font-bold mb-4">
            <i class="fas fa-magic text-purple-400"></i>
            Bienvenue sur MyOCVerse
        </h1>
        <p class="text-xl text-gray-300 mb-6">
            Créez, partagez et découvrez des personnages originaux, des univers fascinants et des races uniques.
        </p>
        
        <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="space-x-4">
                <a href="/register" class="bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded-lg font-semibold transition">
                    Commencer l'aventure
                </a>
                <a href="/login" class="bg-gray-600 hover:bg-gray-700 px-6 py-3 rounded-lg font-semibold transition">
                    Se connecter
                </a>
            </div>
        <?php else: ?>
            <div class="space-x-4">
                <a href="/oc/create" class="bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-plus mr-2"></i>Créer un OC
                </a>
                <a href="/dashboard" class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-lg font-semibold transition">
                    <i class="fas fa-tachometer-alt mr-2"></i>Mon Dashboard
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <div class="lg:col-span-2">
        <h2 class="text-2xl font-bold mb-4 flex items-center">
            <i class="fas fa-star text-yellow-400 mr-2"></i>
            Personnages récents
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($recentOCs as $oc): ?>
                <div class="bg-gray-800 rounded-lg p-4 hover:bg-gray-700 transition">
                    <div class="flex items-center mb-3">
                        <?php if ($oc['avatar']): ?>
                            <img src="<?php echo htmlspecialchars($oc['avatar']); ?>" 
                                 alt="<?php echo htmlspecialchars($oc['name']); ?>" 
                                 class="w-12 h-12 rounded-full mr-3">
                        <?php else: ?>
                            <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-white"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div>
                            <h3 class="font-semibold">
                                <a href="/oc/<?php echo $oc['id']; ?>" class="hover:text-purple-400 transition">
                                    <?php echo htmlspecialchars($oc['name']); ?>
                                </a>
                            </h3>
                            <p class="text-sm text-gray-400">
                                par <a href="/profile/<?php echo $oc['user_id']; ?>" class="hover:text-purple-400">
                                    <?php echo htmlspecialchars($oc['username']); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <?php if ($oc['physical_description']): ?>
                        <p class="text-gray-300 text-sm">
                            <?php echo htmlspecialchars(substr($oc['physical_description'], 0, 100)); ?>...
                        </p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="space-y-6">
        <div>
            <h2 class="text-xl font-bold mb-4 flex items-center">
                <i class="fas fa-globe text-blue-400 mr-2"></i>
                Univers populaires
            </h2>
            
            <?php foreach ($recentUniverses as $universe): ?>
                <div class="bg-gray-800 rounded-lg p-3 mb-3 hover:bg-gray-700 transition">
                    <h3 class="font-semibold">
                        <a href="/universe/<?php echo $universe['id']; ?>" class="hover:text-blue-400 transition">
                            <?php echo htmlspecialchars($universe['name']); ?>
                        </a>
                    </h3>
                    <p class="text-sm text-gray-400">
                        par <?php echo htmlspecialchars($universe['username']); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div>
            <h2 class="text-xl font-bold mb-4 flex items-center">
                <i class="fas fa-dna text-green-400 mr-2"></i>
                Races créées
            </h2>
            
            <?php foreach ($recentRaces as $race): ?>
                <div class="bg-gray-800 rounded-lg p-3 mb-3 hover:bg-gray-700 transition">
                    <h3 class="font-semibold">
                        <a href="/race/<?php echo $race['id']; ?>" class="hover:text-green-400 transition">
                            <?php echo htmlspecialchars($race['name']); ?>
                        </a>
                    </h3>
                    <p class="text-sm text-gray-400">
                        par <?php echo htmlspecialchars($race['username']); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-gray-800 rounded-lg p-6 text-center">
        <div class="text-3xl text-purple-400 mb-4">
            <i class="fas fa-users"></i>
        </div>
        <h3 class="text-xl font-bold mb-2">Communauté active</h3>
        <p class="text-gray-400">
            Rejoignez des milliers de créateurs passionnés
        </p>
    </div>
    
    <div class="bg-gray-800 rounded-lg p-6 text-center">
        <div class="text-3xl text-blue-400 mb-4">
            <i class="fas fa-trophy"></i>
        </div>
        <h3 class="text-xl font-bold mb-2">Système de progression</h3>
        <p class="text-gray-400">
            Gagnez de l'XP et débloquez des badges
        </p>
    </div>
    
    <div class="bg-gray-800 rounded-lg p-6 text-center">
        <div class="text-3xl text-green-400 mb-4">
            <i class="fas fa-heart"></i>
        </div>
        <h3 class="text-xl font-bold mb-2">Interactions sociales</h3>
        <p class="text-gray-400">
            Likez, commentez et partagez vos créations
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'layout.php';
?>