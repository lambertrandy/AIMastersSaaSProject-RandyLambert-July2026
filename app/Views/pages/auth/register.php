<?php
declare(strict_types=1);
?>
<div class="row justify-content-center">
    <div class="col-12 col-md-9 col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-lg-5">
                <div class="mb-4">
                    <span class="badge rounded-pill text-bg-success-subtle text-success-emphasis mb-3">Prompt 1 Scaffold</span>
                    <h1 class="h3 mb-2">Create your account</h1>
                    <p class="text-secondary mb-0">Create your account to access your private task dashboard.</p>
                </div>
                <form method="post" action="/register" novalidate>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Full name</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                class="form-control<?= ! empty($errors['name']) ? ' is-invalid' : '' ?>"
                                value="<?= htmlspecialchars((string) ($old['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                                placeholder="Jane Doe"
                            >
                            <?php if (! empty($errors['name'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-12">
                            <label for="register-email" class="form-label">Email address</label>
                            <input
                                id="register-email"
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
                        <div class="col-md-6">
                            <label for="register-password" class="form-label">Password</label>
                            <input
                                id="register-password"
                                name="password"
                                type="password"
                                class="form-control<?= ! empty($errors['password']) ? ' is-invalid' : '' ?>"
                                placeholder="Create a password"
                            >
                            <?php if (! empty($errors['password'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label for="register-password-confirmation" class="form-label">Confirm password</label>
                            <input
                                id="register-password-confirmation"
                                name="password_confirmation"
                                type="password"
                                class="form-control<?= ! empty($errors['password_confirmation']) ? ' is-invalid' : '' ?>"
                                placeholder="Repeat your password"
                            >
                            <?php if (! empty($errors['password_confirmation'])): ?>
                                <div class="invalid-feedback"><?= htmlspecialchars($errors['password_confirmation'], ENT_QUOTES, 'UTF-8') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mt-4">Create Account</button>
                </form>
                <p class="small text-secondary mt-4 mb-0">
                    Already registered? <a href="/login">Sign in</a>.
                </p>
            </div>
        </div>
    </div>
</div>
