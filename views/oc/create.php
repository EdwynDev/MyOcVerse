<?php
ob_start();
$title = "Créer un OC - MyOCVerse";
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-gray-800 rounded-lg p-8">
        <div class="text-center mb-8">
            <i class="fas fa-plus text-4xl text-purple-400 mb-4"></i>
            <h1 class="text-2xl font-bold">Créer un nouveau personnage</h1>
            <p class="text-gray-400">Donnez vie à votre Original Character</p>
        </div>
        
        <form method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                        Nom du personnage *
                    </label>
                    <input type="text" id="name" name="name" required
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-300 mb-2">
                        Genre
                    </label>
                    <select id="gender" name="gender"
                            class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Sélectionner...</option>
                        <option value="male">Masculin</option>
                        <option value="female">Féminin</option>
                        <option value="non-binary">Non-binaire</option>
                        <option value="other">Autre</option>
                    </select>
                </div>
                
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-300 mb-2">
                        Âge
                    </label>
                    <input type="text" id="age" name="age"
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                           placeholder="Ex: 25 ans, immortel, etc.">
                </div>
                
                <div>
                    <label for="universe_id" class="block text-sm font-medium text-gray-300 mb-2">
                        Univers
                    </label>
                    <select id="universe_id" name="universe_id"
                            class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Aucun univers spécifique</option>
                        <?php foreach ($universes as $universe): ?>
                            <option value="<?php echo $universe['id']; ?>">
                                <?php echo htmlspecialchars($universe['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="race_id" class="block text-sm font-medium text-gray-300 mb-2">
                        Race
                    </label>
                    <select id="race_id" name="race_id"
                            class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Humain / Pas de race spécifique</option>
                        <?php foreach ($races as $race): ?>
                            <option value="<?php echo $race['id']; ?>">
                                <?php echo htmlspecialchars($race['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="privacy" class="block text-sm font-medium text-gray-300 mb-2">
                        Confidentialité
                    </label>
                    <select id="privacy" name="privacy"
                            class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="public">Public</option>
                        <option value="private">Privé</option>
                        <option value="friends">Amis uniquement</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label for="avatar" class="block text-sm font-medium text-gray-300 mb-2">
                    Avatar (URL de l'image)
                </label>
                <input type="url" id="avatar" name="avatar"
                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                       placeholder="https://exemple.com/image.jpg">
            </div>
            
            <div>
                <label for="physical_description" class="block text-sm font-medium text-gray-300 mb-2">
                    Description physique
                </label>
                <textarea id="physical_description" name="physical_description" rows="4"
                          class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                          placeholder="Décrivez l'apparence de votre personnage..."></textarea>
            </div>
            
            <div>
                <label for="mental_description" class="block text-sm font-medium text-gray-300 mb-2">
                    Description mentale / Personnalité
                </label>
                <textarea id="mental_description" name="mental_description" rows="4"
                          class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                          placeholder="Décrivez la personnalité, les traits de caractère..."></textarea>
            </div>
            
            <div>
                <label for="background" class="block text-sm font-medium text-gray-300 mb-2">
                    Histoire / Background
                </label>
                <textarea id="background" name="background" rows="6"
                          class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                          placeholder="Racontez l'histoire de votre personnage..."></textarea>
            </div>
            
            <div>
                <label for="abilities" class="block text-sm font-medium text-gray-300 mb-2">
                    Capacités / Pouvoirs
                </label>
                <textarea id="abilities" name="abilities" rows="4"
                          class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                          placeholder="Décrivez les capacités spéciales de votre personnage..."></textarea>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold mb-4">Attributs personnalisés</h3>
                <div id="attributes-container" class="space-y-3">
                    <div class="flex gap-4">
                        <input type="text" name="attributes[Force]" placeholder="Force"
                               class="flex-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <input type="number" name="attributes[Force]" placeholder="10" min="1" max="100"
                               class="w-20 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div class="flex gap-4">
                        <input type="text" name="attributes[Intelligence]" placeholder="Intelligence"
                               class="flex-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <input type="number" name="attributes[Intelligence]" placeholder="10" min="1" max="100"
                               class="w-20 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div class="flex gap-4">
                        <input type="text" name="attributes[Agilité]" placeholder="Agilité"
                               class="flex-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <input type="number" name="attributes[Agilité]" placeholder="10" min="1" max="100"
                               class="w-20 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>
                <button type="button" id="add-attribute" class="mt-2 text-purple-400 hover:text-purple-300">
                    <i class="fas fa-plus mr-2"></i>Ajouter un attribut
                </button>
            </div>
            
            <div class="flex justify-between">
                <a href="/dashboard" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-md transition">
                    Annuler
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md transition">
                    <i class="fas fa-save mr-2"></i>Créer le personnage
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('add-attribute').addEventListener('click', function() {
    const container = document.getElementById('attributes-container');
    const div = document.createElement('div');
    div.className = 'flex gap-4';
    div.innerHTML = `
        <input type="text" name="attributes[]" placeholder="Nom de l'attribut"
               class="flex-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        <input type="number" name="attributes[]" placeholder="10" min="1" max="100"
               class="w-20 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        <button type="button" class="text-red-400 hover:text-red-300 px-2" onclick="this.parentElement.remove()">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(div);
});
</script>

<?php
$content = ob_get_clean();
include '../layout.php';
?>