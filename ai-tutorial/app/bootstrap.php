<?php
declare(strict_types=1);

use App\Core\Application;
use App\Core\Router;

session_start();

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';

    if (! str_starts_with($class, $prefix)) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $path = __DIR__ . '/' . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($path)) {
        require $path;
    }
});

$config = [
    'app' => require __DIR__ . '/Config/app.php',
    'database' => require __DIR__ . '/Config/database.php',
];
$router = new Router();
$app = new Application($config, $router);

require __DIR__ . '/routes.php';

return $app;
