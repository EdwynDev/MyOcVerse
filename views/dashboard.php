<?php
ob_start();
$title = "Dashboard - MyOCVerse";
?>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Profil utilisateur -->
    <div class="lg:col-span-1">
        <div class="bg-gray-800 rounded-lg p-6">
            <div class="text-center mb-6">
                <?php if ($user['avatar']): ?>
                    <img src="<?php echo htmlspecialchars($user['avatar']); ?>" 
                         alt="Avatar" class="w-24 h-24 rounded-full mx-auto mb-4">
                <?php else: ?>
                    <div class="w-24 h-24 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                <?php endif; ?>
                
                <h2 class="text-xl font-bold"><?php echo htmlspecialchars($user['username']); ?></h2>
                <p class="text-gray-400">Niveau <?php echo getLevel($user['xp']); ?></p>
            </div>
            
            <!-- Barre XP -->
            <div class="mb-6">
                <div class="flex justify-between text-sm mb-2">
                    <span>XP: <?php echo $user['xp']; ?></span>
                    <span>Prochain niveau: <?php echo getXPForNextLevel($user['xp']); ?> XP</span>
                </div>
                <div class="bg-gray-700 rounded-full h-2">
                    <div class="bg-purple-600 h-2 rounded-full" 
                         style="width: <?php echo (($user['xp'] % 1000) / 1000) * 100; ?>%"></div>
                </div>
            </div>
            
            <!-- Statistiques -->
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-400">OC créés</span>
                    <span class="font-semibold"><?php echo $stats['oc_count']; ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Univers</span>
                    <span class="font-semibold"><?php echo $stats['universe_count']; ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Races</span>
                    <span class="font-semibold"><?php echo $stats['race_count']; ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Likes reçus</span>
                    <span class="font-semibold text-pink-400"><?php echo $stats['likes_received']; ?></span>
                </div>
            </div>
            
            <!-- Badges -->
            <?php if (!empty($badges)): ?>
                <div class="mt-6">
                    <h3 class="font-bold mb-3">Badges</h3>
                    <div class="grid grid-cols-3 gap-2">
                        <?php foreach (array_slice($badges, 0, 6) as $badge): ?>
                            <div class="bg-gray-700 rounded-lg p-2 text-center" title="<?php echo htmlspecialchars($badge['description']); ?>">
                                <i class="<?php echo $badge['icon']; ?> text-yellow-400"></i>
                                <p class="text-xs mt-1"><?php echo htmlspecialchars($badge['name']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Contenu principal -->
    <div class="lg:col-span-3">
        <!-- Actions rapides -->
        <div class="bg-gray-800 rounded-lg p-6 mb-6">
            <h3 class="text-xl font-bold mb-4">Actions rapides</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="/oc/create" class="bg-purple-600 hover:bg-purple-700 rounded-lg p-4 text-center transition">
                    <i class="fas fa-plus text-2xl mb-2"></i>
                    <p class="font-semibold">Créer un OC</p>
                </a>
                <a href="/universe/create" class="bg-blue-600 hover:bg-blue-700 rounded-lg p-4 text-center transition">
                    <i class="fas fa-globe text-2xl mb-2"></i>
                    <p class="font-semibold">Créer un Univers</p>
                </a>
                <a href="/race/create" class="bg-green-600 hover:bg-green-700 rounded-lg p-4 text-center transition">
                    <i class="fas fa-dna text-2xl mb-2"></i>
                    <p class="font-semibold">Créer une Race</p>
                </a>
            </div>
        </div>
        
        <!-- Mes OC récents -->
        <div class="bg-gray-800 rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Mes OC récents</h3>
                <a href="/community" class="text-purple-400 hover:text-purple-300">Voir tous</a>
            </div>
            
            <?php if (empty($recentOCs)): ?>
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-user-plus text-4xl mb-4"></i>
                    <p>Vous n'avez pas encore créé d'OC.</p>
                    <a href="/oc/create" class="text-purple-400 hover:text-purple-300">Créez votre premier personnage !</a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($recentOCs as $oc): ?>
                        <div class="bg-gray-700 rounded-lg p-4 hover:bg-gray-600 transition">
                            <div class="flex items-center mb-3">
                                <?php if ($oc['avatar']): ?>
                                    <img src="<?php echo htmlspecialchars($oc['avatar']); ?>" 
                                         alt="<?php echo htmlspecialchars($oc['name']); ?>" 
                                         class="w-10 h-10 rounded-full mr-3">
                                <?php else: ?>
                                    <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div>
                                    <h4 class="font-semibold">
                                        <a href="/oc/<?php echo $oc['id']; ?>" class="hover:text-purple-400 transition">
                                            <?php echo htmlspecialchars($oc['name']); ?>
                                        </a>
                                    </h4>
                                    <p class="text-sm text-gray-400">
                                        <?php echo ucfirst($oc['privacy']); ?>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-400">
                                    Créé le <?php echo date('d/m/Y', strtotime($oc['created_at'])); ?>
                                </span>
                                <div class="flex space-x-2">
                                    <a href="/oc/<?php echo $oc['id']; ?>/edit" 
                                       class="text-blue-400 hover:text-blue-300">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/oc/<?php echo $oc['id']; ?>" 
                                       class="text-purple-400 hover:text-purple-300">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Mes univers et races -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-800 rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4">Mes Univers</h3>
                <?php if (empty($recentUniverses)): ?>
                    <div class="text-center py-4 text-gray-400">
                        <p>Aucun univers créé.</p>
                        <a href="/universe/create" class="text-blue-400 hover:text-blue-300">Créer un univers</a>
                    </div>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php foreach (array_slice($recentUniverses, 0, 3) as $universe): ?>
                            <div class="bg-gray-700 rounded-lg p-3">
                                <h4 class="font-semibold">
                                    <a href="/universe/<?php echo $universe['id']; ?>" class="hover:text-blue-400 transition">
                                        <?php echo htmlspecialchars($universe['name']); ?>
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-400"><?php echo htmlspecialchars($universe['genre']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="bg-gray-800 rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4">Mes Races</h3>
                <?php if (empty($recentRaces)): ?>
                    <div class="text-center py-4 text-gray-400">
                        <p>Aucune race créée.</p>
                        <a href="/race/create" class="text-green-400 hover:text-green-300">Créer une race</a>
                    </div>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php foreach (array_slice($recentRaces, 0, 3) as $race): ?>
                            <div class="bg-gray-700 rounded-lg p-3">
                                <h4 class="font-semibold">
                                    <a href="/race/<?php echo $race['id']; ?>" class="hover:text-green-400 transition">
                                        <?php echo htmlspecialchars($race['name']); ?>
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-400">
                                    <?php echo htmlspecialchars(substr($race['description'], 0, 50)); ?>...
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'layout.php';
?>