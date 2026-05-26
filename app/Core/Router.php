<?php

namespace app\Core;

class Router {
    private $routes = [];

    public function get($route, $action) {
        $this->routes['GET'][$this->formatRoute($route)] = $action;
    }

    public function post($route, $action) {
        $this->routes['POST'][$this->formatRoute($route)] = $action;
    }

    private function formatRoute($route) {
        $route = rtrim($route, '/');
        if ($route === '') {
            $route = '/';
        }
        return preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_-]+)', $route);
    }

    public function dispatch($url) {
        $url = '/' . rtrim($url, '/');
        if ($url === '//') {
            $url = '/';
        }
        
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routePattern => $action) {
                // Ensure the route pattern matches exactly from start to end
                $pattern = '#^' . $routePattern . '$#';
                if (preg_match($pattern, $url, $matches)) {
                    // Remove numeric keys
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    
                    list($controllerName, $methodName) = explode('@', $action);
                    $controllerClass = "app\\Controllers\\$controllerName";
                    
                    if (class_exists($controllerClass)) {
                        $controller = new $controllerClass();
                        if (method_exists($controller, $methodName)) {
                            call_user_func_array([$controller, $methodName], $params);
                            return;
                        } else {
                            echo "Method $methodName not found in controller $controllerName";
                            return;
                        }
                    } else {
                        echo "Controller $controllerName not found";
                        return;
                    }
                }
            }
        }
        
        // 404
        http_response_code(404);
        echo "404 Not Found";
    }
}
