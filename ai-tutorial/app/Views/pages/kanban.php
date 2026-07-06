<?php
declare(strict_types=1);

$statusLabels = [
    'todo' => 'To Do',
    'in_progress' => 'In Progress',
    'done' => 'Done',
];

$priorityClasses = [
    'low' => 'secondary',
    'medium' => 'info',
    'high' => 'warning',
    'urgent' => 'danger',
];

$columns = $columns ?? [
    'todo' => [],
    'in_progress' => [],
    'done' => [],
];
?>
<section class="mb-4 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
    <div>
        <span class="badge rounded-pill text-bg-info-subtle text-info-emphasis mb-2">Kanban Board</span>
        <h1 class="h2 mb-1">Kanban board</h1>
        <p class="text-secondary mb-0">Move your tasks between columns using the status control on each card.</p>
    </div>
    <a class="btn btn-primary" href="/tasks/create">Create Task</a>
</section>

<?php if ($columns['todo'] === [] && $columns['in_progress'] === [] && $columns['done'] === []): ?>
    <section class="card border-0 shadow-sm">
        <div class="card-body p-5 text-center">
            <h2 class="h4 mb-2">No tasks on the board yet</h2>
            <p class="text-secondary mb-4">Create your first task to populate the kanban columns.</p>
            <a class="btn btn-primary" href="/tasks/create">Create Your First Task</a>
        </div>
    </section>
<?php else: ?>
<div class="row g-4">
    <?php foreach ($columns as $status => $cards): ?>
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0"><?= htmlspecialchars($statusLabels[$status] ?? $status, ENT_QUOTES, 'UTF-8') ?></h2>
                        <span class="badge rounded-pill text-bg-secondary"><?= count($cards) ?></span>
                    </div>
                </div>
                <div class="card-body d-grid gap-3">
                    <?php if ($cards === []): ?>
                        <div class="border rounded-3 p-3 bg-body-tertiary text-secondary small">
                            No tasks in this column.
                        </div>
                    <?php else: ?>
                        <?php foreach ($cards as $card): ?>
                            <article class="border rounded-3 p-3 bg-body-tertiary">
                                <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                    <div>
                                        <h3 class="h6 mb-1">
                                            <a class="text-decoration-none" href="/tasks/<?= htmlspecialchars((string) $card['id'], ENT_QUOTES, 'UTF-8') ?>">
                                                <?= htmlspecialchars($card['title'], ENT_QUOTES, 'UTF-8') ?>
                                            </a>
                                        </h3>
                                        <p class="small text-secondary mb-0">
                                            <?= htmlspecialchars((string) ($card['description'] !== '' ? (strlen($card['description']) > 70 ? substr($card['description'], 0, 67) . '...' : $card['description']) : 'No description provided'), ENT_QUOTES, 'UTF-8') ?>
                                        </p>
                                    </div>
                                    <span class="badge text-bg-<?= $priorityClasses[$card['priority']] ?? 'secondary' ?>">
                                        <?= htmlspecialchars(ucwords($card['priority']), ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </div>
                                <p class="small text-secondary mb-3">
                                    Due: <?= htmlspecialchars((string) ($card['due_date'] ?: 'Not set'), ENT_QUOTES, 'UTF-8') ?>
                                </p>
                                <div class="d-grid gap-2">
                                    <form method="post" action="/tasks/<?= htmlspecialchars((string) $card['id'], ENT_QUOTES, 'UTF-8') ?>/status">
                                        <label for="status-<?= htmlspecialchars((string) $card['id'], ENT_QUOTES, 'UTF-8') ?>" class="form-label small">Move to</label>
                                        <div class="input-group input-group-sm">
                                            <select id="status-<?= htmlspecialchars((string) $card['id'], ENT_QUOTES, 'UTF-8') ?>" name="status" class="form-select">
                                                <?php foreach ($statusLabels as $optionValue => $optionLabel): ?>
                                                    <option value="<?= htmlspecialchars($optionValue, ENT_QUOTES, 'UTF-8') ?>"<?= $card['status'] === $optionValue ? ' selected' : '' ?>>
                                                        <?= htmlspecialchars($optionLabel, ENT_QUOTES, 'UTF-8') ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" class="btn btn-outline-primary">Update</button>
                                        </div>
                                    </form>
                                    <div class="d-flex gap-2">
                                        <a class="btn btn-sm btn-outline-secondary w-100" href="/tasks/<?= htmlspecialchars((string) $card['id'], ENT_QUOTES, 'UTF-8') ?>">View</a>
                                        <a class="btn btn-sm btn-outline-primary w-100" href="/tasks/<?= htmlspecialchars((string) $card['id'], ENT_QUOTES, 'UTF-8') ?>/edit">Edit</a>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
