<?php
declare(strict_types=1);

namespace App\Core;

use App\Http\Request;

final class Application
{
    public function __construct(
        private readonly array $config,
        private readonly Router $router,
    ) {
    }

    public function config(string $key, mixed $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }

    public function router(): Router
    {
        return $this->router;
    }

    public function run(): void
    {
        $request = Request::capture();
        $response = $this->router->dispatch($request, $this);

        http_response_code($response['status']);

        foreach ($response['headers'] as $name => $value) {
            header($name . ': ' . $value);
        }

        echo $response['body'];
    }
}
