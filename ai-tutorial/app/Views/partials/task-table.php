<?php
declare(strict_types=1);

$statusLabels = ['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'];
$statusClasses = ['todo' => 'secondary', 'in_progress' => 'primary', 'done' => 'success'];
$priorityLabels = ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent'];
$priorityClasses = ['low' => 'secondary', 'medium' => 'info', 'high' => 'warning', 'urgent' => 'danger'];
?>
<div id="task-list-container">
    <?php if ($tasks === []): ?>
        <div class="text-center py-5">
            <h2 class="h4 mb-2">No tasks match the current view</h2>
            <p class="text-secondary mb-4">Adjust the filters or create a new task.</p>
            <div class="d-flex justify-content-center gap-2">
                <a href="/tasks" class="btn btn-outline-secondary">Clear Filters</a>
                <a href="/tasks/create" class="btn btn-primary">Create Task</a>
            </div>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr id="task-row-<?= htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <td>
                                <div class="fw-semibold"><?= htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8') ?></div>
                                <div class="small text-secondary"><?= htmlspecialchars((string) ($task['description'] !== '' ? (strlen($task['description']) > 80 ? substr($task['description'], 0, 77) . '...' : $task['description']) : 'No description provided'), ENT_QUOTES, 'UTF-8') ?></div>
                            </td>
                            <td><span class="badge text-bg-<?= $statusClasses[$task['status']] ?? 'secondary' ?>"><?= htmlspecialchars($statusLabels[$task['status']] ?? $task['status'], ENT_QUOTES, 'UTF-8') ?></span></td>
                            <td><span class="badge text-bg-<?= $priorityClasses[$task['priority']] ?? 'secondary' ?>"><?= htmlspecialchars($priorityLabels[$task['priority']] ?? $task['priority'], ENT_QUOTES, 'UTF-8') ?></span></td>
                            <td><?= htmlspecialchars((string) ($task['due_date'] ?: 'Not set'), ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="text-end">
                                <div class="d-flex flex-wrap justify-content-end gap-2">
                                    <a href="/tasks/<?= htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') ?>" class="btn btn-sm btn-outline-secondary">View</a>
                                    <a href="/tasks/<?= htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') ?>/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <?php if ($task['status'] !== 'done'): ?>
                                        <form method="post" action="/tasks/<?= htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') ?>/complete" class="d-inline">
                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-success"
                                                hx-post="/tasks/<?= htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') ?>/complete"
                                                hx-target="#task-list-container"
                                                hx-swap="outerHTML"
                                                hx-include="#task-filters"
                                            >Complete</button>
                                        </form>
                                    <?php endif; ?>
                                    <form method="post" action="/tasks/<?= htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') ?>/delete" class="d-inline" onsubmit="return confirm('Delete this task?');">
                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            hx-post="/tasks/<?= htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') ?>/delete"
                                            hx-target="#task-list-container"
                                            hx-swap="outerHTML"
                                            hx-confirm="Delete this task?"
                                            hx-include="#task-filters"
                                        >Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
