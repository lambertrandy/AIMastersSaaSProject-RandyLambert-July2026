<?php
declare(strict_types=1);

use App\Core\Session;

$success = Session::pull('success');
$error = Session::pull('error');
?>
<?php if (is_string($success) && $success !== ''): ?>
    <div x-data="{ open: true }" x-show="open" x-transition.opacity class="alert alert-success border-0 shadow-sm d-flex justify-content-between align-items-start gap-3 app-alert" role="alert">
        <span><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></span>
        <button type="button" class="btn-close" aria-label="Dismiss alert" @click="open = false"></button>
    </div>
<?php endif; ?>

<?php if (is_string($error) && $error !== ''): ?>
    <div x-data="{ open: true }" x-show="open" x-transition.opacity class="alert alert-danger border-0 shadow-sm d-flex justify-content-between align-items-start gap-3 app-alert" role="alert">
        <span><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></span>
        <button type="button" class="btn-close" aria-label="Dismiss alert" @click="open = false"></button>
    </div>
<?php endif; ?>
