<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Login</h5>
        <?php if ($error): ?>
            <div class="alert alert-danger py-2"><?php echo e($error); ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo url('auth/login'); ?>" autocomplete="off">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label for="user_name" class="form-label">Username</label>
                <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo e($username); ?>" required autofocus>
            </div>
            <div class="mb-3">
                <label for="user_password" class="form-label">Password</label>
                <input type="password" class="form-control" id="user_password" name="user_password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </button>
        </form>
    </div>
</div>
<p class="text-center mt-3 mb-1">Belum punya akun? <a href="<?php echo url('auth/register'); ?>">Daftar di sini</a></p>
