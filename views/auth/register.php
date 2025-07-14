<?php
ob_start();
$title = "Inscription - MyOCVerse";
?>

<div class="max-w-md mx-auto bg-gray-800 rounded-lg p-8">
    <div class="text-center mb-8">
        <i class="fas fa-user-plus text-4xl text-purple-400 mb-4"></i>
        <h1 class="text-2xl font-bold">Inscription</h1>
        <p class="text-gray-400">Rejoignez la communauté MyOCVerse</p>
    </div>
    
    <?php if (!empty($errors)): ?>
        <div class="bg-red-600 text-white p-4 rounded-lg mb-6">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <ul class="list-disc list-inside">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form method="POST" class="space-y-6">
        <div>
            <label for="username" class="block text-sm font-medium text-gray-300 mb-2">
                Nom d'utilisateur
            </label>
            <input type="text" id="username" name="username" required
                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                   placeholder="VotreNom" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
        </div>
        
        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                Email
            </label>
            <input type="email" id="email" name="email" required
                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                   placeholder="votre@email.com" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                Mot de passe
            </label>
            <input type="password" id="password" name="password" required
                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                   placeholder="••••••••">
        </div>
        
        <div>
            <label for="confirm_password" class="block text-sm font-medium text-gray-300 mb-2">
                Confirmer le mot de passe
            </label>
            <input type="password" id="confirm_password" name="confirm_password" required
                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                   placeholder="••••••••">
        </div>
        
        <button type="submit" 
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
            <i class="fas fa-user-plus mr-2"></i>
            S'inscrire
        </button>
    </form>
    
    <div class="text-center mt-6">
        <p class="text-gray-400">
            Déjà un compte ?
            <a href="/login" class="text-purple-400 hover:text-purple-300">
                Connectez-vous !
            </a>
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../layout.php';
?>