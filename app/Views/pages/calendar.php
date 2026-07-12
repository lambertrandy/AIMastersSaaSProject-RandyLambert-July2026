<?php
declare(strict_types=1);

$priorityClasses = [
    'low' => 'secondary',
    'medium' => 'info',
    'high' => 'warning',
    'urgent' => 'danger',
];
?>
<section class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <span class="badge rounded-pill text-bg-danger-subtle text-danger-emphasis mb-2">Calendar</span>
        <h1 class="h2 mb-1"><?= htmlspecialchars($monthLabel, ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="text-secondary mb-0">Review tasks by due date and inspect one day at a time.</p>
    </div>
    <div class="btn-group">
        <a href="/calendar?month=<?= htmlspecialchars($previousMonth, ENT_QUOTES, 'UTF-8') ?>" class="btn btn-outline-secondary">Previous</a>
        <a href="/calendar?month=<?= htmlspecialchars($nextMonth, ENT_QUOTES, 'UTF-8') ?>" class="btn btn-outline-secondary">Next</a>
    </div>
</section>

<div class="row g-4">
    <div class="col-12 col-xl-9">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                    <div class="calendar-weekdays small text-uppercase text-secondary mb-3" style="display:grid; grid-template-columns:repeat(7, minmax(0, 1fr)); gap:0.4rem;">
                        <?php foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $weekday): ?>
                            <div><?= htmlspecialchars($weekday, ENT_QUOTES, 'UTF-8') ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="calendar-grid gap-3" style="display:grid; grid-template-columns:repeat(7, minmax(0, 1fr)); gap:0.4rem;">
                        <?php foreach ($calendarDays as $day): ?>
                            <?php
                            $dayClasses = ['calendar-day', 'border', 'rounded-3', 'p-3'];
                            $dayClasses[] = $day['isCurrentMonth'] ? 'bg-body-tertiary' : 'bg-body-secondary';
                            if ($day['isToday']) {
                                $dayClasses[] = 'border-primary';
                            }
                            if ($day['isSelected']) {
                                $dayClasses[] = 'shadow-sm';
                            }
                            ?>
                            <a
                                href="/calendar?month=<?= htmlspecialchars($monthKey, ENT_QUOTES, 'UTF-8') ?>&date=<?= htmlspecialchars($day['date'], ENT_QUOTES, 'UTF-8') ?>"
                                class="<?= htmlspecialchars(implode(' ', $dayClasses), ENT_QUOTES, 'UTF-8') ?> text-decoration-none text-reset"
                                style="min-height:130px;"
                            >
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong><?= htmlspecialchars($day['day'], ENT_QUOTES, 'UTF-8') ?></strong>
                                    <span class="badge rounded-pill text-bg-light border"><?= count($day['tasks']) ?></span>
                                </div>
                                <?php if ($day['tasks'] === []): ?>
                                    <p class="small text-secondary mb-0">No tasks</p>
                                <?php else: ?>
                                    <div class="d-grid gap-2">
                                        <?php foreach (array_slice($day['tasks'], 0, 3) as $task): ?>
                                            <?php
                                            $badgeClass = $task['status'] === 'done'
                                                ? 'success'
                                                : (($task['due_date'] ?? '') < date('Y-m-d') ? 'danger' : ($priorityClasses[$task['priority']] ?? 'secondary'));
                                            ?>
                                        <div class="small">
                                            <span class="badge text-bg-<?= htmlspecialchars($badgeClass, ENT_QUOTES, 'UTF-8') ?> me-1">
                                                <?= htmlspecialchars(substr($task['title'], 0, 1), ENT_QUOTES, 'UTF-8') ?>
                                            </span>
                                            <?= htmlspecialchars(strlen($task['title']) > 14 ? substr($task['title'], 0, 11) . '...' : $task['title'], ENT_QUOTES, 'UTF-8') ?>
                                        </div>
                                    <?php endforeach; ?>
                                        <?php if (count($day['tasks']) > 3): ?>
                                            <div class="small text-secondary">+<?= count($day['tasks']) - 3 ?> more</div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h2 class="h5 mb-3">Tasks for <?= htmlspecialchars($selectedDateLabel, ENT_QUOTES, 'UTF-8') ?></h2>
                <?php if ($selectedDateTasks === []): ?>
                    <p class="text-secondary mb-0">No tasks are due on this date.</p>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($selectedDateTasks as $task): ?>
                            <?php
                            $statusBadge = $task['status'] === 'done'
                                ? 'success'
                                : (($task['due_date'] ?? '') < date('Y-m-d') ? 'danger' : 'primary');
                            ?>
                            <a href="/tasks/<?= htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') ?>" class="list-group-item list-group-item-action px-0 border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-start gap-3">
                                    <div>
                                        <div class="fw-semibold"><?= htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8') ?></div>
                                        <div class="small text-secondary"><?= htmlspecialchars((string) ($task['description'] !== '' ? (strlen($task['description']) > 80 ? substr($task['description'], 0, 77) . '...' : $task['description']) : 'No description provided'), ENT_QUOTES, 'UTF-8') ?></div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge text-bg-<?= htmlspecialchars($statusBadge, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(str_replace('_', ' ', ucfirst($task['status'])), ENT_QUOTES, 'UTF-8') ?></span>
                                        <div class="small text-secondary mt-1"><?= htmlspecialchars(ucfirst($task['priority']), ENT_QUOTES, 'UTF-8') ?></div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
