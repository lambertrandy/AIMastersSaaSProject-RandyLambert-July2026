<?php
declare(strict_types=1);

$statusClass = ($databaseStatus['connected'] ?? false) ? 'success' : 'danger';
$statusLabel = ($databaseStatus['connected'] ?? false) ? 'Connected' : 'Not Connected';
?>
<div class="alert alert-<?= $statusClass ?> border-0 shadow-sm d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-2" role="alert">
    <div>
        <strong>Database status:</strong> <?= htmlspecialchars($statusLabel, ENT_QUOTES, 'UTF-8') ?>
        <span class="text-body-secondary">
            using <?= htmlspecialchars((string) ($databaseStatus['host'] ?? 'db'), ENT_QUOTES, 'UTF-8') ?>:<?= htmlspecialchars((string) ($databaseStatus['port'] ?? '3306'), ENT_QUOTES, 'UTF-8') ?>/<?= htmlspecialchars((string) ($databaseStatus['database'] ?? 'ai_db'), ENT_QUOTES, 'UTF-8') ?>
        </span>
    </div>
    <?php if (! ($databaseStatus['connected'] ?? false)): ?>
        <small><?= htmlspecialchars((string) ($databaseStatus['message'] ?? 'Connection unavailable.'), ENT_QUOTES, 'UTF-8') ?></small>
    <?php endif; ?>
</div>
