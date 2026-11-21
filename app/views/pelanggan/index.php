<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">Pelanggan</h2>
        <p class="text-secondary mb-0">Daftar pelanggan laundry.</p>
    </div>
    <a href="<?php echo url('pelanggan/tambah'); ?>" class="btn btn-primary align-self-start">
        <i class="bi bi-person-plus me-1"></i> Tambah Pelanggan
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>No</th><th>Nama</th><th>Alamat</th><th>No. HP</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php if (!$rows): ?>
                    <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada data.</td></tr>
                <?php endif; ?>
                <?php $no = 1; foreach ($rows as $r): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo e($r['pel_nama']); ?></td>
                        <td><?php echo e($r['pel_alamat']); ?></td>
                        <td><?php echo e($r['pel_hp']); ?></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="<?php echo url('pelanggan/edit/' . (int) $r['pel_id']); ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                <form method="post" action="<?php echo url('pelanggan/hapus'); ?>" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="id" value="<?php echo (int) $r['pel_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
