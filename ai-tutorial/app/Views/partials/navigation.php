<?php
declare(strict_types=1);

$items = [
    '/dashboard' => 'Dashboard',
    '/tasks' => 'Tasks',
    '/kanban' => 'Kanban',
    '/calendar' => 'Calendar',
];
?>
<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="/dashboard"><?= htmlspecialchars($app->config('name') ?? 'AI Tutorial', ENT_QUOTES, 'UTF-8') ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php foreach ($items as $path => $label): ?>
                    <li class="nav-item">
                        <a class="nav-link<?= ($currentPath ?? '') === $path ? ' active fw-semibold' : '' ?>" href="<?= htmlspecialchars($path, ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-secondary btn-sm" href="/login">Login</a>
                <a class="btn btn-primary btn-sm" href="/register">Register</a>
            </div>
        </div>
    </div>
</nav>
