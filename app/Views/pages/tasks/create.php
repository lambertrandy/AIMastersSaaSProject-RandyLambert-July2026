<?php
declare(strict_types=1);
?>
<section class="mb-4">
    <span class="badge rounded-pill text-bg-primary-subtle text-primary-emphasis mb-2">Create Task</span>
    <h1 class="h2 mb-1">Create a new task</h1>
    <p class="text-secondary mb-0">Add a task to your personal workspace.</p>
</section>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="post" action="/tasks/create" novalidate>
            <?php require dirname(__DIR__, 2) . '/partials/task-form.php'; ?>
        </form>
    </div>
</div>
