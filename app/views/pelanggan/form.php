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
                        <label for="pel_nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="pel_nama" name="pel_nama" maxlength="100" value="<?php echo e($old['pel_nama']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="pel_alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="pel_alamat" name="pel_alamat" rows="3"><?php echo e($old['pel_alamat']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="pel_hp" class="form-label">No. HP</label>
                        <input type="text" class="form-control" id="pel_hp" name="pel_hp" maxlength="30" value="<?php echo e($old['pel_hp']); ?>">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy me-1"></i> Simpan</button>
                        <a href="<?php echo url('pelanggan'); ?>" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i> Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
