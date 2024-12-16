<?php

require_once 'Router.php';

class App
{
    private $router;

    public function __construct()
    {
        // Inisialisasi router
        $this->router = new Router();
    }

    public function run()
    {
        // Ambil metode HTTP (GET, POST, PUT, DELETE, dll.)
        $method = $_SERVER['REQUEST_METHOD'];

        // Ambil URI permintaan dan hilangkan base folder
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri = str_replace('/' . FOLDER_PROJECT, '', $requestUri);

        // Proses permintaan melalui router
        $route = $this->router->resolve($method, $requestUri);

        if ($route) {
            list($controllerName, $methodName) = explode('@', $route['handler']);
            $params = $route['params'];

            // $controllerFile = dirname(__FILE__) . '/../routes/routes.php';
            $controllerFile = dirname(__FILE__) . '/../controllers/' . $controllerName . '.php';

            // Cek apakah file controller ada
            if (file_exists($controllerFile)) {
                require_once $controllerFile;

                // Cek apakah kelas controller ada
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();

                    // Cek apakah metode dalam controller ada
                    if (method_exists($controller, $methodName)) {
                        // Panggil metode controller dengan parameter
                        call_user_func_array(array($controller, $methodName), $params);
                        return;
                    } else {
                        echo "Method not found: $methodName in controller $controllerName.";
                        return;
                    }
                } else {
                    echo "Controller class not found: $controllerName.";
                    return;
                }
            } else {
                echo "Controller file not found: $controllerFile.";
                return;
            }
        }

        // Jika rute tidak ditemukan
        http_response_code(404);
        echo "Route not found for $method $requestUri.";
    }
}
