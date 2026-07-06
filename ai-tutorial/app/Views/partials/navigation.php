<?php
declare(strict_types=1);

$items = [
    '/dashboard' => 'Dashboard',
    '/tasks' => 'Tasks',
    '/kanban' => 'Kanban',
    '/calendar' => 'Calendar',
];
$currentUser = $app->currentUser();
?>
<nav class="navbar navbar-expand-lg app-navbar border-bottom shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="/dashboard">
            <span class="app-brand-mark">AI</span>
            <span><?= htmlspecialchars($app->config('app.name') ?? 'AI Tutorial', ENT_QUOTES, 'UTF-8') ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 app-nav-pills">
                <?php foreach ($items as $path => $label): ?>
                    <li class="nav-item">
                        <a class="nav-link<?= ($currentPath ?? '') === $path ? ' active fw-semibold' : '' ?>" href="<?= htmlspecialchars($path, ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if ($app->isAuthenticated() && is_array($currentUser)): ?>
                <div class="d-flex align-items-center gap-3">
                    <span class="small text-secondary app-user-chip">Signed in as <?= htmlspecialchars($currentUser['name'], ENT_QUOTES, 'UTF-8') ?></span>
                    <form method="post" action="/logout" class="mb-0">
                        <button type="submit" class="btn btn-outline-secondary btn-sm">Logout</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="d-flex gap-2">
                    <a class="btn btn-outline-secondary btn-sm" href="/login">Login</a>
                    <a class="btn btn-primary btn-sm" href="/register">Register</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>
