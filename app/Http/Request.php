<?php
declare(strict_types=1);

namespace App\Http;

final class Request
{
    private array $routeParameters = [];

    public function __construct(
        private readonly string $method,
        private readonly string $path,
    ) {
    }

    public static function capture(): self
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        return new self($method, rtrim($path, '/') ?: '/');
    }

    public function method(): string
    {
        return $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    public function only(array $keys): array
    {
        $values = [];

        foreach ($keys as $key) {
            $values[$key] = $this->input($key);
        }

        return $values;
    }

    public function setRouteParameters(array $parameters): void
    {
        $this->routeParameters = $parameters;
    }

    public function route(string $key, mixed $default = null): mixed
    {
        return $this->routeParameters[$key] ?? $default;
    }

    public function header(string $key, mixed $default = null): mixed
    {
        $serverKey = 'HTTP_' . strtoupper(str_replace('-', '_', $key));

        return $_SERVER[$serverKey] ?? $default;
    }

    public function isHtmx(): bool
    {
        return $this->header('HX-Request') === 'true';
    }
}
