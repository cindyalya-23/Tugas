<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h5 class="fw-bold mb-3">Daftar Akun Baru</h5>
        <?php if ($errors): ?>
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    <?php foreach ($errors as $er): ?><li><?php echo e($er); ?></li><?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="post" action="<?php echo url('auth/register'); ?>" autocomplete="off">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label for="user_namalengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="user_namalengkap" name="user_namalengkap" maxlength="100" value="<?php echo e($old['user_namalengkap']); ?>" required autofocus>
            </div>
            <div class="mb-3">
                <label for="user_name" class="form-label">Username</label>
                <input type="text" class="form-control" id="user_name" name="user_name" maxlength="50" value="<?php echo e($old['user_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="user_password" class="form-label">Password <span class="text-secondary small">(min. 6 karakter)</span></label>
                <input type="password" class="form-control" id="user_password" name="user_password" required>
            </div>
            <div class="mb-3">
                <label for="konfirmasi" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="konfirmasi" name="konfirmasi" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-person-plus me-1"></i> Daftar
            </button>
        </form>
    </div>
</div>
<p class="text-center mt-3">Sudah punya akun? <a href="<?php echo url('auth/login'); ?>">Login</a></p>
