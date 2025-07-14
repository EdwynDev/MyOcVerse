<?php
ob_start();
$title = "Connexion - MyOCVerse";
?>

<div class="max-w-md mx-auto bg-gray-800 rounded-lg p-8">
    <div class="text-center mb-8">
        <i class="fas fa-magic text-4xl text-purple-400 mb-4"></i>
        <h1 class="text-2xl font-bold">Connexion</h1>
        <p class="text-gray-400">Accédez à votre compte MyOCVerse</p>
    </div>
    
    <?php if (isset($error)): ?>
        <div class="bg-red-600 text-white p-4 rounded-lg mb-6">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" class="space-y-6">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                Email
            </label>
            <input type="email" id="email" name="email" required
                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                   placeholder="votre@email.com">
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                Mot de passe
            </label>
            <input type="password" id="password" name="password" required
                   class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                   placeholder="••••••••">
        </div>
        
        <button type="submit" 
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
            <i class="fas fa-sign-in-alt mr-2"></i>
            Se connecter
        </button>
    </form>
    
    <div class="text-center mt-6">
        <p class="text-gray-400">
            Pas encore de compte ?
            <a href="/register" class="text-purple-400 hover:text-purple-300">
                Créez-en un maintenant !
            </a>
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../layout.php';
?>