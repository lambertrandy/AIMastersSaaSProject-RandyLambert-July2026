<?php
declare(strict_types=1);
?>
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">
                <div class="mb-4">
                    <span class="badge rounded-pill text-bg-primary-subtle text-primary-emphasis mb-3">Prompt 1 Scaffold</span>
                    <h1 class="h3 mb-2">Sign in</h1>
                    <p class="text-secondary mb-0">Use your email and password to access your task workspace.</p>
                </div>
                <form method="post" action="/login" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            class="form-control<?= ! empty($errors['email']) ? ' is-invalid' : '' ?>"
                            value="<?= htmlspecialchars((string) ($old['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                            placeholder="you@example.com"
                        >
                        <?php if (! empty($errors['email'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control<?= ! empty($errors['password']) ? ' is-invalid' : '' ?>"
                            placeholder="Enter your password"
                        >
                        <?php if (! empty($errors['password'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </form>
                <p class="small text-secondary mt-4 mb-0">
                    Need an account? <a href="/register">Create one here</a>.
                </p>
            </div>
        </div>
    </div>
</div>
