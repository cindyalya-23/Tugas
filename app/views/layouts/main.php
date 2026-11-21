<?php
$menu = [
    'dashboard' => ['Dashboard', 'bi-speedometer2'],
    'pelanggan' => ['Pelanggan', 'bi-people'],
    'layanan'   => ['Layanan', 'bi-basket'],
    'transaksi' => ['Transaksi', 'bi-receipt'],
];
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title ?? ''); ?> - <?php echo e(APP_NAME); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo url('dashboard'); ?>">
                <i class="bi bi-droplet-half me-1"></i> <?php echo e(APP_NAME); ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-label="Menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav me-auto">
                    <?php foreach ($menu as $key => $m): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo CURRENT_PAGE === $key ? 'active fw-semibold' : ''; ?>" href="<?php echo url($key); ?>">
                                <i class="bi <?php echo $m[1]; ?> me-1"></i><?php echo $m[0]; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <form method="post" action="<?php echo url('auth/logout'); ?>" class="d-flex align-items-center gap-3 text-white mb-0"
                      onsubmit="return confirm('Yakin ingin logout?')">
                    <?php echo csrf_field(); ?>
                    <span class="small"><i class="bi bi-person-circle me-1"></i><?php echo e(auth_user()['nama'] ?? ''); ?></span>
                    <button type="submit" class="btn btn-sm btn-light"><i class="bi bi-box-arrow-right"></i> Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <?php if ($flash): ?>
            <div class="alert alert-<?php echo e($flash['type']); ?> alert-dismissible fade show" role="alert">
                <?php echo e($flash['msg']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        <?php endif; ?>

        <?php echo $content; ?>
    </main>

    <footer class="text-center text-secondary small py-3">
        &copy; <?php echo date('Y'); ?> <?php echo e(APP_NAME); ?> &mdash; PHP MVC
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
