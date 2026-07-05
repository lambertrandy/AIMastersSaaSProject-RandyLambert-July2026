<?php
declare(strict_types=1);

use App\Core\Session;

$success = Session::pull('success');
$error = Session::pull('error');
?>
<?php if (is_string($success) && $success !== ''): ?>
    <div class="alert alert-success border-0 shadow-sm" role="alert">
        <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if (is_string($error) && $error !== ''): ?>
    <div class="alert alert-danger border-0 shadow-sm" role="alert">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>
