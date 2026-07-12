<?php
declare(strict_types=1);

namespace App\Core;

use App\Http\Request;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use PDO;

final class Application
{
    private ?PDO $database = null;
    private ?array $currentUser = null;

    public function __construct(
        private readonly array $config,
        private readonly Router $router,
    ) {
    }

    public function config(string $key, mixed $default = null): mixed
    {
        $segments = explode('.', $key);
        $value = $this->config;

        foreach ($segments as $segment) {
            if (! is_array($value) || ! array_key_exists($segment, $value)) {
                return $default;
            }

            $value = $value[$segment];
        }

        return $value;
    }

    public function database(): PDO
    {
        if ($this->database instanceof PDO) {
            return $this->database;
        }

        $this->database = Database::connect([
            'driver' => (string) $this->config('database.driver', 'mysql'),
            'host' => (string) $this->config('database.host', 'db'),
            'port' => (int) $this->config('database.port', 3306),
            'database' => (string) $this->config('database.database', 'ai_db'),
            'username' => (string) $this->config('database.username', ''),
            'password' => (string) $this->config('database.password', ''),
            'charset' => (string) $this->config('database.charset', 'utf8mb4'),
        ]);

        return $this->database;
    }

    public function router(): Router
    {
        return $this->router;
    }

    public function users(): UserRepository
    {
        return new UserRepository($this->database());
    }

    public function tasks(): TaskRepository
    {
        return new TaskRepository($this->database());
    }

    public function isAuthenticated(): bool
    {
        return Auth::check();
    }

    public function currentUser(): ?array
    {
        if (! $this->isAuthenticated()) {
            return null;
        }

        if ($this->currentUser !== null) {
            return $this->currentUser;
        }

        $this->currentUser = $this->users()->findById(Auth::id() ?? 0);

        if ($this->currentUser === null) {
            Auth::logout();
        }

        return $this->currentUser;
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
