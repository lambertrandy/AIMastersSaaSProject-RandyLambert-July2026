<?php
declare(strict_types=1);
?>
<div class="row justify-content-center">
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm text-center">
            <div class="card-body p-5">
                <span class="badge rounded-pill text-bg-dark mb-3">404</span>
                <h1 class="h2 mb-3">Page not found</h1>
                <p class="text-secondary mb-4">No route is registered for <code><?= htmlspecialchars($currentPath ?? '', ENT_QUOTES, 'UTF-8') ?></code>.</p>
                <a class="btn btn-primary" href="/dashboard">Go to dashboard</a>
            </div>
        </div>
    </div>
</div>
