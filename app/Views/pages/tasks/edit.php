<?php
declare(strict_types=1);
?>
<section class="mb-4 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <span class="badge rounded-pill text-bg-warning-subtle text-warning-emphasis mb-2">Edit Task</span>
        <h1 class="h2 mb-1">Edit task</h1>
        <p class="text-secondary mb-0">Update the task details and save your changes.</p>
    </div>
    <a href="/tasks/<?= htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') ?>" class="btn btn-outline-secondary">View Detail</a>
</section>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="post" action="/tasks/<?= htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') ?>/edit" novalidate>
            <?php require dirname(__DIR__, 2) . '/partials/task-form.php'; ?>
        </form>
    </div>
</div>
