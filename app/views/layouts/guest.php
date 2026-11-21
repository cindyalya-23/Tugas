<?php $flash = get_flash(); ?>
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
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100 py-4">
            <div class="col-12 col-sm-9 col-md-7 col-lg-5 col-xl-4">
                <div class="text-center mb-4">
                    <i class="bi bi-droplet-half text-primary" style="font-size: 3rem;"></i>
                    <h3 class="fw-bold mt-2"><?php echo e(APP_NAME); ?></h3>
                </div>
                <?php if ($flash): ?>
                    <div class="alert alert-<?php echo e($flash['type']); ?>"><?php echo e($flash['msg']); ?></div>
                <?php endif; ?>
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</body>
</html>
