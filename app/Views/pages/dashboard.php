<?php
declare(strict_types=1);

$summaryCards = [
    ['label' => 'Total Tasks', 'value' => (string) ($summary['total_tasks'] ?? 0), 'accent' => 'primary'],
    ['label' => 'Completed', 'value' => (string) ($summary['completed_tasks'] ?? 0), 'accent' => 'success'],
    ['label' => 'Open Tasks', 'value' => (string) ($summary['open_tasks'] ?? 0), 'accent' => 'warning'],
    ['label' => 'Due Today', 'value' => (string) ($summary['due_today_tasks'] ?? 0), 'accent' => 'info'],
];

$hasTasks = (int) ($summary['total_tasks'] ?? 0) > 0;

$renderTaskList = static function (array $tasks, string $emptyText): void {
    if ($tasks === []) {
        echo '<p class="text-secondary mb-0">' . htmlspecialchars($emptyText, ENT_QUOTES, 'UTF-8') . '</p>';
        return;
    }

    echo '<div class="list-group list-group-flush">';

    foreach ($tasks as $task) {
        echo '<a class="list-group-item list-group-item-action px-0 border-0 border-bottom" href="/tasks/' . htmlspecialchars((string) $task['id'], ENT_QUOTES, 'UTF-8') . '">';
        echo '<div class="d-flex justify-content-between align-items-start gap-3">';
        echo '<div>';
        echo '<div class="fw-semibold">' . htmlspecialchars($task['title'], ENT_QUOTES, 'UTF-8') . '</div>';
        echo '<div class="small text-secondary">' . htmlspecialchars((string) ($task['due_date'] ?: 'No due date'), ENT_QUOTES, 'UTF-8') . '</div>';
        echo '</div>';
        echo '<span class="badge text-bg-light border">' . htmlspecialchars(ucwords(str_replace('_', ' ', $task['priority'])), ENT_QUOTES, 'UTF-8') . '</span>';
        echo '</div>';
        echo '</a>';
    }

    echo '</div>';
};
?>
<section class="mb-4">
    <?php require dirname(__DIR__) . '/partials/database-status.php'; ?>
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <span class="badge rounded-pill text-bg-primary-subtle text-primary-emphasis mb-2">Dashboard</span>
            <h1 class="h2 mb-1">Your productivity dashboard</h1>
            <p class="text-secondary mb-0">Track your current workload, due dates, and recently completed items.</p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="/tasks">View tasks</a>
            <a class="btn btn-primary" href="/tasks/create">Create task</a>
        </div>
    </div>
</section>

<section class="row g-3 mb-4">
    <?php foreach ($summaryCards as $card): ?>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 border-top border-4 border-<?= htmlspecialchars($card['accent'], ENT_QUOTES, 'UTF-8') ?>">
                <div class="card-body">
                    <p class="text-secondary text-uppercase small mb-2"><?= htmlspecialchars($card['label'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p class="display-6 mb-0"><?= htmlspecialchars($card['value'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<?php if (! $hasTasks): ?>
    <section class="card border-0 shadow-sm">
        <div class="card-body p-5 text-center">
            <h2 class="h4 mb-2">No tasks yet</h2>
            <p class="text-secondary mb-4">Create your first task to populate the dashboard and start tracking your work.</p>
            <a class="btn btn-primary" href="/tasks/create">Create Your First Task</a>
        </div>
    </section>
<?php else: ?>
<section class="row g-4">
    <div class="col-12 col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h2 class="h5">Due Today</h2>
                <?php $renderTaskList($dueTodayTasks, 'No tasks are due today.'); ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h2 class="h5">Upcoming Tasks</h2>
                <?php $renderTaskList($upcomingTasks, 'No upcoming tasks are scheduled yet.'); ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h2 class="h5">Overdue Tasks</h2>
                <?php $renderTaskList($overdueTasks, 'Nothing is overdue.'); ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h2 class="h5">Recently Completed</h2>
                <?php $renderTaskList($recentlyCompletedTasks, 'Complete a task to see it appear here.'); ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
