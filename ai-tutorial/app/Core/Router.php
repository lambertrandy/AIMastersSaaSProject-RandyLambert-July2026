<?php
declare(strict_types=1);

namespace App\Core;

use App\Http\Request;

final class Router
{
    /**
     * @var array<string, array<string, callable>>
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
        $handler = $methodRoutes[$request->path()] ?? null;

        if ($handler === null) {
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

    private function map(string $method, string $path, callable $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }
}
