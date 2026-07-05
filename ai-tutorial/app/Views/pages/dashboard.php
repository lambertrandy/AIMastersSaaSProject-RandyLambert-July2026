<?php
declare(strict_types=1);
?>
<section class="mb-4">
    <?php require dirname(__DIR__) . '/partials/database-status.php'; ?>
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
        <div>
            <span class="badge rounded-pill text-bg-primary-subtle text-primary-emphasis mb-2">Dashboard Placeholder</span>
            <h1 class="h2 mb-1">Your productivity dashboard</h1>
            <p class="text-secondary mb-0">Prompt 5 will replace these static cards and lists with real user-specific task data.</p>
        </div>
        <a class="btn btn-primary" href="/tasks">View tasks</a>
    </div>
</section>

<section class="row g-3 mb-4">
    <?php foreach ([
        'Total Tasks' => '24',
        'Completed' => '8',
        'In Progress' => '9',
        'Due Today' => '3',
    ] as $label => $value): ?>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary text-uppercase small mb-2"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></p>
                    <p class="display-6 mb-0"><?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<section class="row g-4">
    <div class="col-12 col-xl-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h2 class="h5">Today's priorities</h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0">Finalize onboarding copy</li>
                    <li class="list-group-item px-0">Review July sprint tasks</li>
                    <li class="list-group-item px-0">Prepare kanban board states</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h2 class="h5">Upcoming milestones</h2>
                <div class="d-grid gap-3">
                    <div class="p-3 rounded bg-body-tertiary">
                        <strong>Authentication</strong>
                        <p class="small text-secondary mb-0">Prompt 3 will turn the login and registration placeholders into working flows.</p>
                    </div>
                    <div class="p-3 rounded bg-body-tertiary">
                        <strong>Task data</strong>
                        <p class="small text-secondary mb-0">Prompt 4 will connect CRUD screens to MariaDB.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
