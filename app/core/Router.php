<?php 

class Router{
    private $routes = array();

    public function register($path, $handler){
        $this->routes[$path] = $handler;
    }

    public function resolve($requestUri) {
        foreach ($this->routes as $path => $handler) {
            // Ganti parameter dinamis {id} menjadi regex
            $pattern = preg_replace('/\{[a-zA-Z_]+\}/', '(\d+)', $path);
            if (preg_match("#^$pattern$#", $requestUri, $matches)) {
                array_shift($matches); // Remove full match
                return ['handler' => $handler, 'params' => $matches];
            }
        }
        return null;
    }

    public function getRoutes() {
        return $this->routes;
    }
}
?>