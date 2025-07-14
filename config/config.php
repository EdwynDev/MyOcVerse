<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'u316670446_myocverse');
define('DB_USER', 'u316670446_myocverse');
define('DB_PASS', 'ak.QDT44AEdtqwS');

define('SITE_NAME', 'MyOCVerse');
define('SITE_URL', 'https://myocverse.neopolyworks.fr');
define('UPLOAD_PATH', 'uploads/');

// Configurations XP
define('XP_CREATE_OC', 50);
define('XP_CREATE_UNIVERSE', 100);
define('XP_CREATE_RACE', 75);
define('XP_RECEIVE_LIKE', 5);
define('XP_COMMENT', 10);
define('XP_EVENT_PARTICIPATION', 200);

// Niveaux
function getLevel($xp) {
    return floor($xp / 1000) + 1;
}

function getXPForNextLevel($xp) {
    $currentLevel = getLevel($xp);
    return $currentLevel * 1000 - ($xp % 1000);
}
?>