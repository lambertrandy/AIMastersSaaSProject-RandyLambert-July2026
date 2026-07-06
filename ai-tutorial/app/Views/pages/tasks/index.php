<?php
declare(strict_types=1);

$statusLabels = ['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'];
$statusClasses = ['todo' => 'secondary', 'in_progress' => 'primary', 'done' => 'success'];
$priorityLabels = ['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent'];
$priorityClasses = ['low' => 'secondary', 'medium' => 'info', 'high' => 'warning', 'urgent' => 'danger'];
$filters = $filters ?? [
    'status' => 'all',
    'priority' => 'all',
    'due_state' => 'all',
    'sort' => 'created_desc',
];
?>
<section class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <span class="badge rounded-pill text-bg-warning-subtle text-warning-emphasis mb-2">Task Manager</span>
        <h1 class="h2 mb-1">Tasks</h1>
        <p class="text-secondary mb-0">Create, review, update, complete, and delete your tasks.</p>
    </div>
    <a href="/tasks/create" class="btn btn-primary">Create Task</a>
</section>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="get" action="/tasks" class="row g-3 mb-4">
            <div class="col-md-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="all"<?= $filters['status'] === 'all' ? ' selected' : '' ?>>All statuses</option>
                    <option value="todo"<?= $filters['status'] === 'todo' ? ' selected' : '' ?>>To Do</option>
                    <option value="in_progress"<?= $filters['status'] === 'in_progress' ? ' selected' : '' ?>>In Progress</option>
                    <option value="done"<?= $filters['status'] === 'done' ? ' selected' : '' ?>>Done</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="priority" class="form-label">Priority</label>
                <select id="priority" name="priority" class="form-select">
                    <option value="all"<?= $filters['priority'] === 'all' ? ' selected' : '' ?>>All priorities</option>
                    <option value="low"<?= $filters['priority'] === 'low' ? ' selected' : '' ?>>Low</option>
                    <option value="medium"<?= $filters['priority'] === 'medium' ? ' selected' : '' ?>>Medium</option>
                    <option value="high"<?= $filters['priority'] === 'high' ? ' selected' : '' ?>>High</option>
                    <option value="urgent"<?= $filters['priority'] === 'urgent' ? ' selected' : '' ?>>Urgent</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="due_state" class="form-label">Due Date</label>
                <select id="due_state" name="due_state" class="form-select">
                    <option value="all"<?= $filters['due_state'] === 'all' ? ' selected' : '' ?>>All due dates</option>
                    <option value="today"<?= $filters['due_state'] === 'today' ? ' selected' : '' ?>>Due today</option>
                    <option value="upcoming"<?= $filters['due_state'] === 'upcoming' ? ' selected' : '' ?>>Upcoming</option>
                    <option value="overdue"<?= $filters['due_state'] === 'overdue' ? ' selected' : '' ?>>Overdue</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="sort" class="form-label">Sort</label>
                <select id="sort" name="sort" class="form-select">
                    <option value="created_desc"<?= $filters['sort'] === 'created_desc' ? ' selected' : '' ?>>Newest first</option>
                    <option value="created_asc"<?= $filters['sort'] === 'created_asc' ? ' selected' : '' ?>>Oldest first</option>
                    <option value="due_asc"<?= $filters['sort'] === 'due_asc' ? ' selected' : '' ?>>Due date ascending</option>
                    <option value="due_desc"<?= $filters['sort'] === 'due_desc' ? ' selected' : '' ?>>Due date descending</option>
                    <option value="priority_desc"<?= $filters['sort'] === 'priority_desc' ? ' selected' : '' ?>>Priority high to low</option>
                    <option value="priority_asc"<?= $filters['sort'] === 'priority_asc' ? ' selected' : '' ?>>Priority low to high</option>
                </select>
            </div>
            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary">Apply Filters</button>
                <a href="/tasks" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>

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
                            <tr>
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
                                                <button type="submit" class="btn btn-sm btn-outline-success">Complete</button>
                                            </form>
                                        <?php endif; ?>
                                        <form method="post" action="/tasks/<?= htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') ?>/delete" class="d-inline" onsubmit="return confirm('Delete this task?');">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
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
</div>
