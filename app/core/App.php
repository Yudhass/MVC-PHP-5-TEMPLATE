<?php

require_once 'Router.php';
class App
{

    private $router;

    public function __construct()
    {
        $this->router = new Router();

        // Muat rute dari file routes.php
        $routes = require __DIR__ . '/../routes/routes.php';
        foreach ($routes as $path => $handler) {
            $this->router->register($path, $handler);
        }
    }

    public function run()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Hilangkan '/template/' dari URL jika aplikasi berjalan dalam subfolder
        $requestUri = str_replace('/template', '', $requestUri);

        $route = $this->router->resolve($requestUri);

        if ($route) {
            list($controllerName, $method) = explode('@', $route['handler']);
            $params = $route['params'];

            $controllerFile = __DIR__ . "/../controllers/$controllerName.php";

            if (file_exists($controllerFile)) {
                require_once $controllerFile;

                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    if (method_exists($controller, $method)) {
                        call_user_func_array([$controller, $method], $params);
                        return;
                    } else {
                        echo "Method not found: $method in controller $controllerName.";
                        return;
                    }
                } else {
                    echo "Controller class not found: $controllerName.";
                    return;
                }
            } else {
                echo "Controller file not found: $controllerFile";
                return;
            }
        }

        // Jika rute tidak ditemukan
        http_response_code(404);
        echo "Route not found.";
    }
}
