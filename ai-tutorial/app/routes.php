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

$taskInput = static function (Request $request): array {
    return [
        'title' => trim((string) $request->input('title', '')),
        'description' => trim((string) $request->input('description', '')),
        'status' => (string) $request->input('status', 'todo'),
        'priority' => (string) $request->input('priority', 'medium'),
        'due_date' => trim((string) $request->input('due_date', '')),
    ];
};

$taskListFilters = static function (Request $request): array {
    return [
        'status' => (string) $request->input('status', 'all'),
        'priority' => (string) $request->input('priority', 'all'),
        'due_state' => (string) $request->input('due_state', 'all'),
        'sort' => (string) $request->input('sort', 'created_desc'),
    ];
};

$validateTask = static function (array $task): array {
    $errors = [];
    $allowedStatuses = ['todo', 'in_progress', 'done'];
    $allowedPriorities = ['low', 'medium', 'high', 'urgent'];

    if ($task['title'] === '') {
        $errors['title'] = 'Title is required.';
    }

    if (! in_array($task['status'], $allowedStatuses, true)) {
        $errors['status'] = 'Choose a valid status.';
    }

    if (! in_array($task['priority'], $allowedPriorities, true)) {
        $errors['priority'] = 'Choose a valid priority.';
    }

    if ($task['due_date'] !== '') {
        $date = \DateTime::createFromFormat('Y-m-d', $task['due_date']);
        if (! $date || $date->format('Y-m-d') !== $task['due_date']) {
            $errors['due_date'] = 'Enter a valid due date.';
        }
    }

    return $errors;
};

$validTaskStatuses = ['todo', 'in_progress', 'done'];

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

    if ($errors !== []) {
        Session::flash('old', ['email' => $email]);
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

    if ($errors === [] && $app->users()->findByEmail($email) !== null) {
        $errors['email'] = 'That email address is already registered.';
    }

    if ($errors !== []) {
        Session::flash('old', [
            'name' => $name,
            'email' => $email,
        ]);
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

    $userId = Auth::id() ?? 0;
    $summary = $app->tasks()->dashboardSummary($userId);
    $dueTodayTasks = $app->tasks()->dueTodayForUser($userId);
    $upcomingTasks = $app->tasks()->upcomingForUser($userId);
    $overdueTasks = $app->tasks()->overdueForUser($userId);
    $recentlyCompletedTasks = $app->tasks()->recentlyCompletedForUser($userId);

    return $render('pages/dashboard', 'Dashboard', $request->path(), 'app', [
        'databaseStatus' => $databaseStatus,
        'summary' => $summary,
        'dueTodayTasks' => $dueTodayTasks,
        'upcomingTasks' => $upcomingTasks,
        'overdueTasks' => $overdueTasks,
        'recentlyCompletedTasks' => $recentlyCompletedTasks,
    ]);
});

$router->get('/tasks', static function (Request $request, Application $app) use ($render, $authRedirect, $taskListFilters): string|array {
    $response = $authRedirect();

    if ($response !== null) {
        return $response;
    }

    $filters = $taskListFilters($request);

    return $render('pages/tasks/index', 'Tasks', $request->path(), 'app', [
        'tasks' => $app->tasks()->filteredForUser(Auth::id() ?? 0, $filters),
        'filters' => $filters,
    ]);
});

$router->get('/tasks/create', static function (Request $request) use ($render, $authRedirect): string|array {
    $response = $authRedirect();

    if ($response !== null) {
        return $response;
    }

    return $render('pages/tasks/create', 'Create Task', $request->path(), 'app', [
        'task' => Session::pull('old', []),
        'errors' => Session::pull('errors', []),
        'submitLabel' => 'Create Task',
    ]);
});

$router->post('/tasks/create', static function (Request $request, Application $app) use ($redirect, $taskInput, $validateTask): array {
    $task = $taskInput($request);
    $errors = $validateTask($task);

    if ($errors !== []) {
        Session::flash('old', $task);
        Session::flash('errors', $errors);
        return $redirect('/tasks/create');
    }

    $taskId = $app->tasks()->create(Auth::id() ?? 0, $task);
    Session::flash('success', 'Task created successfully.');

    return $redirect('/tasks/' . $taskId);
});

$router->get('/tasks/{id}', static function (Request $request, Application $app) use ($render, $authRedirect): string|array {
    $response = $authRedirect();

    if ($response !== null) {
        return $response;
    }

    $task = $app->tasks()->findForUser((int) $request->route('id'), Auth::id() ?? 0);

    if ($task === null) {
        Session::flash('error', 'Task not found.');
        return $redirect('/tasks');
    }

    return $render('pages/tasks/show', 'Task Detail', $request->path(), 'app', [
        'task' => $task,
    ]);
});

$router->get('/tasks/{id}/edit', static function (Request $request, Application $app) use ($render, $authRedirect): string|array {
    $response = $authRedirect();

    if ($response !== null) {
        return $response;
    }

    $task = Session::pull('old');
    $storedTask = $app->tasks()->findForUser((int) $request->route('id'), Auth::id() ?? 0);

    if ($storedTask === null) {
        Session::flash('error', 'Task not found.');
        return $redirect('/tasks');
    }

    return $render('pages/tasks/edit', 'Edit Task', $request->path(), 'app', [
        'task' => is_array($task) && $task !== [] ? array_merge($storedTask, $task) : $storedTask,
        'errors' => Session::pull('errors', []),
        'submitLabel' => 'Save Changes',
    ]);
});

$router->post('/tasks/{id}/edit', static function (Request $request, Application $app) use ($redirect, $taskInput, $validateTask): array {
    $taskId = (int) $request->route('id');
    $existingTask = $app->tasks()->findForUser($taskId, Auth::id() ?? 0);

    if ($existingTask === null) {
        Session::flash('error', 'Task not found.');
        return $redirect('/tasks');
    }

    $task = $taskInput($request);
    $task['completed_at'] = $existingTask['completed_at'];
    $errors = $validateTask($task);

    if ($errors !== []) {
        Session::flash('old', $task);
        Session::flash('errors', $errors);
        return $redirect('/tasks/' . $taskId . '/edit');
    }

    $app->tasks()->update($taskId, Auth::id() ?? 0, $task);
    Session::flash('success', 'Task updated successfully.');

    return $redirect('/tasks/' . $taskId);
});

$router->post('/tasks/{id}/complete', static function (Request $request, Application $app) use ($redirect): array {
    $taskId = (int) $request->route('id');
    $task = $app->tasks()->findForUser($taskId, Auth::id() ?? 0);

    if ($task === null) {
        Session::flash('error', 'Task not found.');
        return $redirect('/tasks');
    }

    $app->tasks()->markComplete($taskId, Auth::id() ?? 0);
    Session::flash('success', 'Task marked complete.');

    return $redirect('/tasks/' . $taskId);
});

$router->post('/tasks/{id}/delete', static function (Request $request, Application $app) use ($redirect): array {
    $taskId = (int) $request->route('id');
    $task = $app->tasks()->findForUser($taskId, Auth::id() ?? 0);

    if ($task === null) {
        Session::flash('error', 'Task not found.');
        return $redirect('/tasks');
    }

    $app->tasks()->delete($taskId, Auth::id() ?? 0);
    Session::flash('success', 'Task deleted successfully.');

    return $redirect('/tasks');
});

$router->post('/tasks/{id}/status', static function (Request $request, Application $app) use ($redirect, $validTaskStatuses): array {
    $taskId = (int) $request->route('id');
    $task = $app->tasks()->findForUser($taskId, Auth::id() ?? 0);

    if ($task === null) {
        Session::flash('error', 'Task not found.');
        return $redirect('/kanban');
    }

    $status = (string) $request->input('status', '');
    if (! in_array($status, $validTaskStatuses, true)) {
        Session::flash('error', 'Invalid status selection.');
        return $redirect('/kanban');
    }

    $app->tasks()->updateStatus($taskId, Auth::id() ?? 0, $status);
    Session::flash('success', 'Task status updated.');

    return $redirect('/kanban');
});

$router->get('/kanban', static function (Request $request, Application $app) use ($render, $authRedirect): string|array {
    $response = $authRedirect();

    if ($response !== null) {
        return $response;
    }

    return $render('pages/kanban', 'Kanban Board', $request->path(), 'app', [
        'columns' => $app->tasks()->groupedByStatusForUser(Auth::id() ?? 0),
    ]);
});

$router->get('/calendar', static function (Request $request) use ($render, $authRedirect): string|array {
    $response = $authRedirect();

    if ($response !== null) {
        return $response;
    }

    return $render('pages/calendar', 'Calendar', $request->path(), 'app');
});
