<?php

class Router
{
    private $routes = [];

    public function __construct()
    {
        // Muat semua rute dari file konfigurasi
        $this->routes = require_once __DIR__ . '/../routes/routes.php';
    }

    public function resolve($method, $uri)
    {
        foreach ($this->routes as $route) {
            list($routeMethod, $routePath, $handler) = $route;

            // Cek metode HTTP
            if ($method !== $routeMethod) {
                continue;
            }

            // Cek URL dengan parameter dinamis
            $pattern = $this->convertToRegex($routePath);
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Hapus elemen pertama (full match)
                return [
                    'handler' => $handler,
                    'params' => $matches,
                ];
            }
        }

        return null; // Tidak ditemukan
    }

    private function convertToRegex($path)
    {
        // Ubah {param} menjadi regex
        return '/^' . preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', str_replace('/', '\/', $path)) . '$/';
    }
}
