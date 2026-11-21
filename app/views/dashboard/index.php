<?php
$kartu = [
    ['Pelanggan', $jmlPelanggan, 'bi-people', 'primary'],
    ['Layanan', $jmlLayanan, 'bi-basket', 'success'],
    ['Transaksi', $jmlTransaksi, 'bi-receipt', 'warning'],
    ['Belum Selesai', $belumSelesai, 'bi-hourglass-split', 'danger'],
];
?>
<div class="mb-4">
    <h2 class="fw-bold mb-1">Dashboard</h2>
    <p class="text-secondary mb-0">Selamat datang, <?php echo e(auth_user()['nama'] ?? ''); ?>.</p>
</div>

<div class="row g-3 mb-4">
    <?php foreach ($kartu as $k): ?>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="fs-1 text-<?php echo $k[3]; ?>"><i class="bi <?php echo $k[2]; ?>"></i></div>
                    <div>
                        <div class="text-secondary small"><?php echo $k[0]; ?></div>
                        <div class="fs-4 fw-bold"><?php echo (int) $k[1]; ?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body d-flex align-items-center gap-3">
        <div class="fs-1 text-success"><i class="bi bi-cash-coin"></i></div>
        <div>
            <div class="text-secondary small">Total Pendapatan</div>
            <div class="fs-3 fw-bold"><?php echo rupiah($pendapatan); ?></div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold">Transaksi Terbaru</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>No</th><th>Pelanggan</th><th>Layanan</th><th>Tgl Masuk</th><th>Status</th><th class="text-end">Total</th></tr>
            </thead>
            <tbody>
                <?php if (!$terbaru): ?>
                    <tr><td colspan="6" class="text-center text-secondary py-4">Belum ada transaksi.</td></tr>
                <?php endif; ?>
                <?php foreach ($terbaru as $t): ?>
                    <tr>
                        <td>#<?php echo (int) $t['trans_id']; ?></td>
                        <td><?php echo e($t['pel_nama']); ?></td>
                        <td><?php echo e($t['lay_jenis']); ?></td>
                        <td><?php echo tgl($t['trans_tgl_masuk']); ?></td>
                        <td>
                            <?php if ($t['trans_tgl_selesai']): ?>
                                <span class="badge text-bg-success">Selesai</span>
                            <?php else: ?>
                                <span class="badge text-bg-warning">Proses</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end"><?php echo rupiah($t['trans_total']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
