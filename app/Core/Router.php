<?php
declare(strict_types=1);

namespace App\Core;

use App\Http\Request;

final class Router
{
    /**
     * @var array<string, array<int, array{path: string, handler: callable, pattern: string}>>
     */
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->map('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->map('POST', $path, $handler);
    }

    public function dispatch(Request $request, Application $app): array
    {
        $methodRoutes = $this->routes[$request->method()] ?? [];

        foreach ($methodRoutes as $route) {
            if (! preg_match($route['pattern'], $request->path(), $matches)) {
                continue;
            }

            $routeParameters = array_filter(
                $matches,
                static fn (string|int $key): bool => is_string($key),
                ARRAY_FILTER_USE_KEY
            );
            $request->setRouteParameters($routeParameters);
            $handler = $route['handler'];
            $response = $handler($request, $app);

            if (is_array($response) && isset($response['status'], $response['headers'], $response['body'])) {
                return $response;
            }

            return [
                'status' => 200,
                'headers' => [],
                'body' => (string) $response,
            ];
        }

        return [
            'status' => 404,
            'headers' => [],
            'body' => View::render('pages/not-found', [
                'app' => $app,
                'pageTitle' => 'Page Not Found',
                'currentPath' => $request->path(),
            ]),
        ];
    }

    private function map(string $method, string $path, callable $handler): void
    {
        $this->routes[$method][] = [
            'path' => $path,
            'handler' => $handler,
            'pattern' => $this->compilePattern($path),
        ];
    }

    private function compilePattern(string $path): string
    {
        $escaped = preg_replace_callback(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            static fn (array $matches): string => '(?P<' . $matches[1] . '>[^/]+)',
            $path
        );

        return '#^' . $escaped . '$#';
    }
}
