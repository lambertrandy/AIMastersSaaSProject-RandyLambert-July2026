<?php
declare(strict_types=1);

use App\Core\Application;
use App\Core\View;
use App\Http\Request;

$render = static function (
    string $template,
    string $pageTitle,
    string $currentPath,
    string $layout = 'app',
    array $data = [],
) use ($app): string {
    return View::render($template, array_merge($data, [
        'app' => $app,
        'pageTitle' => $pageTitle,
        'currentPath' => $currentPath,
    ]), $layout);
};

$router->get('/', static function (): array {
    return [
        'status' => 302,
        'headers' => ['Location' => '/login'],
        'body' => '',
    ];
});

$router->get('/login', static function (Request $request) use ($render): string {
    return $render('pages/auth/login', 'Login', $request->path(), 'guest');
});

$router->get('/register', static function (Request $request) use ($render): string {
    return $render('pages/auth/register', 'Register', $request->path(), 'guest');
});

$router->get('/logout', static function (): array {
    return [
        'status' => 302,
        'headers' => ['Location' => '/login'],
        'body' => '',
    ];
});

$router->get('/dashboard', function (Request $request, Application $app) use ($render): string {
    $databaseStatus = [
        'connected' => false,
        'host' => $app->config('database.host'),
        'port' => $app->config('database.port'),
        'database' => $app->config('database.database'),
        'message' => null,
    ];

    try {
        $app->database();
        $databaseStatus['connected'] = true;
    } catch (\Throwable $throwable) {
        $databaseStatus['message'] = $throwable->getMessage();
    }

    return $render('pages/dashboard', 'Dashboard', $request->path(), 'app', [
        'databaseStatus' => $databaseStatus,
    ]);
});

$router->get('/tasks', static function (Request $request) use ($render): string {
    return $render('pages/tasks/index', 'Tasks', $request->path(), 'app');
});

$router->get('/kanban', static function (Request $request) use ($render): string {
    return $render('pages/kanban', 'Kanban Board', $request->path(), 'app');
});

$router->get('/calendar', static function (Request $request) use ($render): string {
    return $render('pages/calendar', 'Calendar', $request->path(), 'app');
});
