<?php

namespace Core;

use Core\Middleware\Middleware;

class Route
{
    private array $handlers;
    private const METHOD_POST = 'POST';
    private const METHOD_GET = 'GET';

    public static function get(string $path, $callback, $middleware = null): array
    {
        return [
            'method' => self::METHOD_GET,
            'path' => $path,
            'callback' => $callback,
            'middleware' => $middleware
        ];
    }

    public static function post(string $path, $callback, $middleware = null): array
    {
        return [
            'method' => self::METHOD_POST,
            'path' => $path,
            'callback' => $callback,
            'middleware' => $middleware
        ];
    }

    protected function addHandler(string $method, string $path, $handler, $middleware): void
    {
        $this->handlers[$method . $path] = [
            'handler' => $handler,
            'method' => $method,
            'path' => $path,
            'middleware' => $middleware
        ];
    }

    public function addRoutes(array $routes): void
    {
        foreach ($routes as $route) {
            $this->addHandler($route['method'], $route['path'], $route['callback'], $route['middleware']);
        }
    }

    public function run(): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $currentRoute = $method . $requestPath;

        if (!$this->routeIsDefined($currentRoute)) {
            $this->checkRouteParams($currentRoute);
        }

        // confirm current route is set
        // TODO: check the request method also
        if (!$this->routeIsDefined($currentRoute)) {
            abort(404, 'Page not found');
        }

        // check csrf_token for post requests
        if (strtolower(request()->getMethod()) == 'post') {
            if (!session()->has('csrf_token')) {
                abort(419, 'Page expired');
            }

            if (request()->input('csrf_token') !== session()->get('csrf_token')) {
                abort(419, 'CSRF token mismatch');
            }
        }
        
        // resolve middleware
        (new Middleware())->resolve($this->handlers[$currentRoute]['middleware']);

        $callback = $this->handlers[$currentRoute]['handler'];

        if ($callback instanceof View) {
            View::display($callback);
            return;
        }

        if (is_callable($callback)) {
            $value = call_user_func($callback, []);

            if (!is_null($value) && $value instanceof View) {
                View::display($value);
            }

            return;
        }

        if (is_string($callback)) {
            echo $callback;
            return;
        }

        if (is_array($callback) && count($callback) > 0 && count($callback) < 3) {
            if (!class_exists($callback[0])) {
                die('Class does not exist');
                return;
            }

            $class = new $callback[0];
            $params = $this->handlers[$currentRoute]['url_params'] ?? [];

            if (count($callback) == 1 && method_exists($class, '__invoke')) {
                call_user_func_array($class, $params);
                return;
            }

            if (count($callback) == 2 && method_exists($class, $callback[1])) {
                $value = call_user_func_array(array($class, $callback[1]), $params);
                if (!is_null($value) && $value instanceof View) {
                    View::display($value);
                }
                return;
            }

            die('Invalid method "' . ($callback[1] ?? '__invoke') . '" in class - ' . $callback[0]);
        }
    }

    protected function list(): array
    {
        return array_keys($this->handlers) ?? [];
    }

    protected function routeIsDefined($route)
    {
        return in_array($route, $this->list() ?? []);
    }

    protected function checkRouteParams($currentRoute): void
    {
        $routesWithParams = [];
        $newHandlers = [];

        // start iteration registered routes
        foreach ($this->list() as $route) {
            $routeNames = [];

            //Remove 'GET/' and trim slashes
            $cleanedRoute = trim(str_replace('GET', '', $route), '/');

            if (!$cleanedRoute) {
                continue;
            }

            // /greeting/{greeting} => /greeting/(\w+)
            // /greeting/{greeting}/{name} => /greeting/(\w+)/(\w+)
            // Find all route names from route and save in $routeNames
            if (preg_match_all('/\{(:\w+)}/', $cleanedRoute, $matches)) {
                $routeNames = $matches[1];
            }

            // Convert route name into regex pattern
            $routeRegex = "@^" . preg_replace_callback('/\{:\w+}/', fn ($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $cleanedRoute) . "$@";

            // Test and match current route against $routeRegex
            if (preg_match_all($routeRegex, trim(str_replace('GET', '', $currentRoute), '/'), $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);

                $routesWithParams[$currentRoute] = $routeParams;
                $cleanedRouteParams = [];
                foreach ($routeParams as $param => $value) {
                    $cleanedRouteParams[str_replace(":", "", $param)] = $value;
                }
                $newHandlers[$currentRoute] = array_merge($this->handlers[$route], [
                    "url_params" => $cleanedRouteParams ?? []
                ]);
            } else {
                $newHandlers[$route] = $this->handlers[$route];
            }
        }

        // update the handlers list
        $this->handlers = $newHandlers;
    }
}
