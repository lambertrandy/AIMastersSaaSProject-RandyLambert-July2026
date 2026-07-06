<?php
declare(strict_types=1);

$statusLabels = ['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'];
$priorityLabels = ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent'];
?>
<section class="mb-4 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <span class="badge rounded-pill text-bg-info-subtle text-info-emphasis mb-2">Task Detail</span>
        <h1 class="h2 mb-1"><?= htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="text-secondary mb-0">Review the full task details and manage its status.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="/tasks/<?= htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') ?>/edit" class="btn btn-primary">Edit Task</a>
        <a href="/tasks" class="btn btn-outline-secondary">Back to Tasks</a>
    </div>
</section>

<div class="row g-4">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h2 class="h5 mb-3">Description</h2>
                <p class="mb-0"><?= nl2br(htmlspecialchars((string) ($task['description'] ?: 'No description provided.'), ENT_QUOTES, 'UTF-8')) ?></p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h2 class="h5 mb-3">Task Details</h2>
                <dl class="row mb-0">
                    <dt class="col-5">Status</dt>
                    <dd class="col-7"><?= htmlspecialchars($statusLabels[$task['status']] ?? $task['status'], ENT_QUOTES, 'UTF-8') ?></dd>
                    <dt class="col-5">Priority</dt>
                    <dd class="col-7"><?= htmlspecialchars($priorityLabels[$task['priority']] ?? $task['priority'], ENT_QUOTES, 'UTF-8') ?></dd>
                    <dt class="col-5">Due Date</dt>
                    <dd class="col-7"><?= htmlspecialchars((string) ($task['due_date'] ?: 'Not set'), ENT_QUOTES, 'UTF-8') ?></dd>
                    <dt class="col-5">Created</dt>
                    <dd class="col-7"><?= htmlspecialchars((string) $task['created_at'], ENT_QUOTES, 'UTF-8') ?></dd>
                    <dt class="col-5">Updated</dt>
                    <dd class="col-7"><?= htmlspecialchars((string) $task['updated_at'], ENT_QUOTES, 'UTF-8') ?></dd>
                    <dt class="col-5">Completed</dt>
                    <dd class="col-7"><?= htmlspecialchars((string) ($task['completed_at'] ?: 'Not completed'), ENT_QUOTES, 'UTF-8') ?></dd>
                </dl>
                <div class="d-grid gap-2 mt-4">
                    <?php if ($task['status'] !== 'done'): ?>
                        <form method="post" action="/tasks/<?= htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') ?>/complete">
                            <button type="submit" class="btn btn-success w-100">Mark Complete</button>
                        </form>
                    <?php endif; ?>
                    <form method="post" action="/tasks/<?= htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') ?>/delete" onsubmit="return confirm('Delete this task?');">
                        <button type="submit" class="btn btn-outline-danger w-100">Delete Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
