<?php
declare(strict_types=1);

$days = [
    ['date' => '1', 'tasks' => []],
    ['date' => '2', 'tasks' => []],
    ['date' => '3', 'tasks' => ['Kickoff']],
    ['date' => '4', 'tasks' => []],
    ['date' => '5', 'tasks' => ['Wireframe review']],
    ['date' => '6', 'tasks' => ['Prompt 1 check']],
    ['date' => '7', 'tasks' => ['DB setup']],
];
?>
<section class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <span class="badge rounded-pill text-bg-danger-subtle text-danger-emphasis mb-2">Calendar Placeholder</span>
        <h1 class="h2 mb-1">Calendar</h1>
        <p class="text-secondary mb-0">Prompt 8 will connect this view to due dates and month navigation.</p>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-outline-secondary">Previous</button>
        <button type="button" class="btn btn-outline-secondary">Next</button>
    </div>
</section>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-grid calendar-grid gap-3">
            <?php foreach ($days as $day): ?>
                <div class="border rounded-3 p-3 bg-body-tertiary">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong><?= htmlspecialchars($day['date'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <span class="badge rounded-pill text-bg-light border"><?= count($day['tasks']) ?></span>
                    </div>
                    <?php if ($day['tasks'] === []): ?>
                        <p class="small text-secondary mb-0">No tasks</p>
                    <?php else: ?>
                        <ul class="small mb-0 ps-3">
                            <?php foreach ($day['tasks'] as $task): ?>
                                <li><?= htmlspecialchars($task, ENT_QUOTES, 'UTF-8') ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
