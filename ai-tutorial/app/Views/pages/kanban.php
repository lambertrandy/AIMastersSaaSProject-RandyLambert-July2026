<?php
declare(strict_types=1);

$columns = [
    'To Do' => [
        ['title' => 'Create task repository layer', 'priority' => 'Urgent', 'due' => 'Jul 7'],
        ['title' => 'Style registration view', 'priority' => 'Medium', 'due' => 'Jul 9'],
    ],
    'In Progress' => [
        ['title' => 'Scaffold dashboard widgets', 'priority' => 'High', 'due' => 'Jul 6'],
    ],
    'Done' => [
        ['title' => 'Create project planning docs', 'priority' => 'Low', 'due' => 'Completed'],
    ],
];
?>
<section class="mb-4">
    <span class="badge rounded-pill text-bg-info-subtle text-info-emphasis mb-2">Kanban Placeholder</span>
    <h1 class="h2 mb-1">Kanban board</h1>
    <p class="text-secondary mb-0">Prompt 7 will replace these sample cards with real task groupings and status controls.</p>
</section>

<div class="row g-4">
    <?php foreach ($columns as $columnName => $cards): ?>
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0"><?= htmlspecialchars($columnName, ENT_QUOTES, 'UTF-8') ?></h2>
                        <span class="badge rounded-pill text-bg-secondary"><?= count($cards) ?></span>
                    </div>
                </div>
                <div class="card-body d-grid gap-3">
                    <?php foreach ($cards as $card): ?>
                        <article class="border rounded-3 p-3 bg-body-tertiary">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <h3 class="h6 mb-2"><?= htmlspecialchars($card['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                                <span class="badge text-bg-light border"><?= htmlspecialchars($card['priority'], ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                            <p class="small text-secondary mb-0">Due: <?= htmlspecialchars($card['due'], ENT_QUOTES, 'UTF-8') ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
