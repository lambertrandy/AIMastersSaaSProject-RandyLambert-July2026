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
                    <p class="text-secondary mb-0">This registration UI is in place so Prompt 3 can focus on validation, password hashing, and sessions.</p>
                </div>
                <form>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Full name</label>
                            <input id="name" type="text" class="form-control" placeholder="Jane Doe">
                        </div>
                        <div class="col-12">
                            <label for="register-email" class="form-label">Email address</label>
                            <input id="register-email" type="email" class="form-control" placeholder="you@example.com">
                        </div>
                        <div class="col-md-6">
                            <label for="register-password" class="form-label">Password</label>
                            <input id="register-password" type="password" class="form-control" placeholder="Create a password">
                        </div>
                        <div class="col-md-6">
                            <label for="register-password-confirmation" class="form-label">Confirm password</label>
                            <input id="register-password-confirmation" type="password" class="form-control" placeholder="Repeat your password">
                        </div>
                    </div>
                    <button type="button" class="btn btn-success w-100 mt-4">Register Placeholder</button>
                </form>
                <p class="small text-secondary mt-4 mb-0">
                    Already registered? <a href="/login">Sign in</a>.
                </p>
            </div>
        </div>
    </div>
</div>
