<div class="mb-4">
    <h2 class="fw-bold mb-1"><?php echo e($title); ?></h2>
</div>
<div class="row">
    <div class="col-12 col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <?php if ($errors): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $er): ?><li><?php echo e($er); ?></li><?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form method="post" action="<?php echo url($action); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="lay_jenis" class="form-label">Jenis Layanan</label>
                        <input type="text" class="form-control" id="lay_jenis" name="lay_jenis" maxlength="100" value="<?php echo e($old['lay_jenis']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="lay_harga" class="form-label">Harga per Kg (Rp)</label>
                        <input type="number" class="form-control" id="lay_harga" name="lay_harga" min="1" value="<?php echo e($old['lay_harga']); ?>" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy me-1"></i> Simpan</button>
                        <a href="<?php echo url('layanan'); ?>" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i> Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
