<?php
namespace App;

class Router {
    private array $routes = [];

    public function add(string $method, string $pattern, string $controller, string $action): void {
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function get(string $pattern, string $controller, string $action): void {
        $this->add('GET', $pattern, $controller, $action);
    }

    public function post(string $pattern, string $controller, string $action): void {
        $this->add('POST', $pattern, $controller, $action);
    }

    public function dispatch(string $method, string $uri): void {
        $path = parse_url($uri, PHP_URL_PATH);
        $path = rtrim($path, '/');
        $path = $path ?: '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== strtoupper($method)) continue;

            $params = $this->match($route['pattern'], $path);
            if ($params !== false) {
                $controller = new $route['controller']();
                $action = $route['action'];
                $controller->$action(...array_values($params));
                return;
            }
        }

        $this->notFound();
    }

    private function match(string $pattern, string $path): array|false {
        // تحويل {id} إلى نمط Regex
        $regex = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';

        if (preg_match($regex, $path, $matches)) {
            return array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        }
        return false;
    }

    private function notFound(): void {
        http_response_code(404);
        echo "<h1>404 - الصفحة غير موجودة</h1>";
    }
}