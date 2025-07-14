<?php
class Router {
    private $routes = [];
    
    public function add($route, $handler) {
        $this->routes[$route] = $handler;
    }
    
    public function dispatch($uri) {
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // Recherche exacte
        if (isset($this->routes[$uri])) {
            $this->callHandler($this->routes[$uri]);
            return;
        }
        
        // Recherche avec paramètres
        foreach ($this->routes as $route => $handler) {
            $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                $this->callHandler($handler, $matches);
                return;
            }
        }
        
        // 404
        http_response_code(404);
        include 'views/404.php';
    }
    
    private function callHandler($handler, $params = []) {
        list($controllerName, $method) = explode('@', $handler);
        
        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            }
        }
    }
}
?>