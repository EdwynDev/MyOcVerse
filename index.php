<?php
session_start();
require_once 'config/config.php';
require_once 'core/Database.php';
require_once 'core/Router.php';
require_once 'core/Controller.php';
require_once 'core/Model.php';

// Auto-loader simple
spl_autoload_register(function($class) {
    $paths = [
        'controllers/',
        'models/',
        'core/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$router = new Router();

// Routes principales
$router->add('/', 'HomeController@index');
$router->add('/login', 'AuthController@login');
$router->add('/register', 'AuthController@register');
$router->add('/logout', 'AuthController@logout');
$router->add('/dashboard', 'DashboardController@index');
$router->add('/profile/{id}', 'ProfileController@show');
$router->add('/oc/create', 'OCController@create');
$router->add('/oc/{id}', 'OCController@show');
$router->add('/oc/{id}/edit', 'OCController@edit');
$router->add('/universe/create', 'UniverseController@create');
$router->add('/universe/{id}', 'UniverseController@show');
$router->add('/race/create', 'RaceController@create');
$router->add('/race/{id}', 'RaceController@show');
$router->add('/community', 'CommunityController@index');
$router->add('/events', 'EventController@index');
$router->add('/leaderboard', 'LeaderboardController@index');
$router->add('/search', 'SearchController@index');

$router->dispatch($_SERVER['REQUEST_URI']);
?>