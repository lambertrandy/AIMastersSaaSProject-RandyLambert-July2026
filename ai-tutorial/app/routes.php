<?php
declare(strict_types=1);

use App\Core\Auth;
use App\Core\Application;
use App\Core\Session;
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

$redirect = static fn (string $location): array => [
    'status' => 302,
    'headers' => ['Location' => $location],
    'body' => '',
];

$authRedirect = static function (): ?array {
    if (! Auth::check()) {
        Session::flash('error', 'Please log in to continue.');

        return [
            'status' => 302,
            'headers' => ['Location' => '/login'],
            'body' => '',
        ];
    }

    return null;
};

$guestRedirect = static function (): ?array {
    if (Auth::check()) {
        return [
            'status' => 302,
            'headers' => ['Location' => '/dashboard'],
            'body' => '',
        ];
    }

    return null;
};

$router->get('/', static function () use ($redirect): array {
    if (Auth::check()) {
        return $redirect('/dashboard');
    }

    return $redirect('/login');
});

$router->get('/login', static function (Request $request) use ($render, $guestRedirect): string|array {
    $response = $guestRedirect();

    if ($response !== null) {
        return $response;
    }

    return $render('pages/auth/login', 'Login', $request->path(), 'guest', [
        'errors' => Session::pull('errors', []),
        'old' => Session::pull('old', []),
    ]);
});

$router->post('/login', static function (Request $request, Application $app) use ($redirect): array {
    $email = trim((string) $request->input('email', ''));
    $password = (string) $request->input('password', '');
    $errors = [];

    if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }

    if ($password === '') {
        $errors['password'] = 'Password is required.';
    }

    Session::flash('old', ['email' => $email]);

    if ($errors !== []) {
        Session::flash('errors', $errors);

        return $redirect('/login');
    }

    $user = $app->users()->findByEmail($email);

    if (! is_array($user) || ! password_verify($password, (string) $user['password_hash'])) {
        Session::flash('error', 'Invalid email or password.');

        return $redirect('/login');
    }

    Auth::login((int) $user['id']);
    Session::flash('success', 'Welcome back, ' . $user['name'] . '.');

    return $redirect('/dashboard');
});

$router->get('/register', static function (Request $request) use ($render, $guestRedirect): string|array {
    $response = $guestRedirect();

    if ($response !== null) {
        return $response;
    }

    return $render('pages/auth/register', 'Register', $request->path(), 'guest', [
        'errors' => Session::pull('errors', []),
        'old' => Session::pull('old', []),
    ]);
});

$router->post('/register', static function (Request $request, Application $app) use ($redirect): array {
    $name = trim((string) $request->input('name', ''));
    $email = trim((string) $request->input('email', ''));
    $password = (string) $request->input('password', '');
    $passwordConfirmation = (string) $request->input('password_confirmation', '');
    $errors = [];

    if ($name === '') {
        $errors['name'] = 'Name is required.';
    }

    if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }

    if ($password === '') {
        $errors['password'] = 'Password is required.';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters.';
    }

    if ($passwordConfirmation === '') {
        $errors['password_confirmation'] = 'Please confirm your password.';
    } elseif ($password !== $passwordConfirmation) {
        $errors['password_confirmation'] = 'Password confirmation does not match.';
    }

    Session::flash('old', [
        'name' => $name,
        'email' => $email,
    ]);

    if ($errors === [] && $app->users()->findByEmail($email) !== null) {
        $errors['email'] = 'That email address is already registered.';
    }

    if ($errors !== []) {
        Session::flash('errors', $errors);

        return $redirect('/register');
    }

    $userId = $app->users()->create(
        $name,
        $email,
        password_hash($password, PASSWORD_DEFAULT)
    );

    Auth::login($userId);
    Session::flash('success', 'Your account has been created.');

    return $redirect('/dashboard');
});

$router->get('/logout', static function () use ($redirect): array {
    Auth::logout();
    Session::flash('success', 'You have been logged out.');

    return $redirect('/login');
});

$router->post('/logout', static function () use ($redirect): array {
    Auth::logout();
    Session::flash('success', 'You have been logged out.');

    return $redirect('/login');
});

$router->get('/dashboard', function (Request $request, Application $app) use ($render, $authRedirect): string|array {
    $response = $authRedirect();

    if ($response !== null) {
        return $response;
    }

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

$router->get('/tasks', static function (Request $request) use ($render, $authRedirect): string|array {
    $response = $authRedirect();

    if ($response !== null) {
        return $response;
    }

    return $render('pages/tasks/index', 'Tasks', $request->path(), 'app');
});

$router->get('/kanban', static function (Request $request) use ($render, $authRedirect): string|array {
    $response = $authRedirect();

    if ($response !== null) {
        return $response;
    }

    return $render('pages/kanban', 'Kanban Board', $request->path(), 'app');
});

$router->get('/calendar', static function (Request $request) use ($render, $authRedirect): string|array {
    $response = $authRedirect();

    if ($response !== null) {
        return $response;
    }

    return $render('pages/calendar', 'Calendar', $request->path(), 'app');
});
