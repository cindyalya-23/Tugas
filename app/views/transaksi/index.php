<?php $grand = 0; ?>
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">Transaksi</h2>
        <p class="text-secondary mb-0">Riwayat transaksi laundry.</p>
    </div>
    <a href="<?php echo url('transaksi/tambah'); ?>" class="btn btn-primary align-self-start">
        <i class="bi bi-plus-circle me-1"></i> Tambah Transaksi
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th><th>Pelanggan</th><th>Layanan</th><th>Masuk</th><th>Selesai</th>
                    <th class="text-end">Berat</th><th class="text-end">Total</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$rows): ?>
                    <tr><td colspan="8" class="text-center text-secondary py-4">Belum ada transaksi.</td></tr>
                <?php endif; ?>
                <?php foreach ($rows as $r): $grand += (int) $r['trans_total']; ?>
                    <tr>
                        <td>#<?php echo (int) $r['trans_id']; ?></td>
                        <td><?php echo e($r['pel_nama']); ?></td>
                        <td><?php echo e($r['lay_jenis']); ?></td>
                        <td><?php echo tgl($r['trans_tgl_masuk']); ?></td>
                        <td>
                            <?php if ($r['trans_tgl_selesai']): ?>
                                <?php echo tgl($r['trans_tgl_selesai']); ?>
                            <?php else: ?>
                                <span class="badge text-bg-warning">Proses</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end"><?php echo (int) $r['trans_berat']; ?> kg</td>
                        <td class="text-end"><?php echo rupiah($r['trans_total']); ?></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="<?php echo url('transaksi/edit/' . (int) $r['trans_id']); ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                <form method="post" action="<?php echo url('transaksi/hapus'); ?>" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="id" value="<?php echo (int) $r['trans_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <?php if ($rows): ?>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="6" class="text-end">Total Keseluruhan</th>
                        <th class="text-end"><?php echo rupiah($grand); ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>
