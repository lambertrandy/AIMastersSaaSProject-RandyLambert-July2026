<?php
declare(strict_types=1);

?>
<section class="mb-4 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <span class="badge rounded-pill text-bg-info-subtle text-info-emphasis mb-2">Kanban Board</span>
        <h1 class="h2 mb-1">Kanban board</h1>
        <p class="text-secondary mb-0">Move your tasks between columns using the status control on each card.</p>
    </div>
    <a class="btn btn-primary" href="/tasks/create">Create Task</a>
</section>
<?php require dirname(__DIR__) . '/partials/kanban-board.php'; ?>
