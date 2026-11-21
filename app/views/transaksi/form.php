<div class="mb-4">
    <h2 class="fw-bold mb-1"><?php echo e($title); ?></h2>
</div>
<div class="row">
    <div class="col-12 col-lg-8">
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
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="trans_id_pelanggan" class="form-label">Pelanggan</label>
                            <select class="form-select" id="trans_id_pelanggan" name="trans_id_pelanggan" required>
                                <option value="">-- Pilih pelanggan --</option>
                                <?php foreach ($daftarPel as $p): ?>
                                    <option value="<?php echo (int) $p['pel_id']; ?>" <?php echo (string) $old['trans_id_pelanggan'] === (string) $p['pel_id'] ? 'selected' : ''; ?>>
                                        <?php echo e($p['pel_nama']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="trans_id_layanan" class="form-label">Layanan</label>
                            <select class="form-select" id="trans_id_layanan" name="trans_id_layanan" required>
                                <option value="" data-harga="0">-- Pilih layanan --</option>
                                <?php foreach ($daftarLay as $l): ?>
                                    <option value="<?php echo (int) $l['lay_id']; ?>" data-harga="<?php echo (int) $l['lay_harga']; ?>" <?php echo (string) $old['trans_id_layanan'] === (string) $l['lay_id'] ? 'selected' : ''; ?>>
                                        <?php echo e($l['lay_jenis']); ?> (<?php echo rupiah($l['lay_harga']); ?>/kg)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="trans_tgl_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control" id="trans_tgl_masuk" name="trans_tgl_masuk" value="<?php echo e($old['trans_tgl_masuk']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="trans_tgl_selesai" class="form-label">Tanggal Selesai <span class="text-secondary small">(kosongkan jika belum)</span></label>
                            <input type="date" class="form-control" id="trans_tgl_selesai" name="trans_tgl_selesai" value="<?php echo e($old['trans_tgl_selesai']); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="trans_berat" class="form-label">Berat (kg)</label>
                            <input type="number" class="form-control" id="trans_berat" name="trans_berat" min="1" value="<?php echo e($old['trans_berat']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Perkiraan Total</label>
                            <div class="form-control bg-light fw-bold" id="total_preview">Rp 0</div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-floppy me-1"></i> Simpan</button>
                        <a href="<?php echo url('transaksi'); ?>" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i> Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    (function () {
        var lay = document.getElementById('trans_id_layanan');
        var berat = document.getElementById('trans_berat');
        var out = document.getElementById('total_preview');

        function hitung() {
            var opt = lay.options[lay.selectedIndex];
            var harga = parseInt(opt ? opt.getAttribute('data-harga') : 0, 10) || 0;
            var kg = parseInt(berat.value, 10) || 0;
            out.textContent = 'Rp ' + (harga * kg).toLocaleString('id-ID');
        }

        lay.addEventListener('change', hitung);
        berat.addEventListener('input', hitung);
        hitung();
    })();
</script>
