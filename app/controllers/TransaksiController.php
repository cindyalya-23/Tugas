<?php

class TransaksiController extends Controller
{
    private Transaksi $model;

    public function __construct()
    {
        $this->requireLogin();
        $this->model = new Transaksi();
    }

    public function index()
    {
        $this->view('transaksi/index', ['title' => 'Transaksi', 'rows' => $this->model->all()]);
    }

    public function tambah()
    {
        $errors = [];
        $old = [
            'trans_id_pelanggan' => '', 'trans_id_layanan' => '',
            'trans_tgl_masuk' => date('Y-m-d'), 'trans_tgl_selesai' => '', 'trans_berat' => '',
        ];

        if ($this->isPost()) {
            csrf_check();
            [$old, $errors] = $this->validasi();
            if (!$errors) {
                $this->model->create($this->siapkan($old));
                flash('success', 'Transaksi baru berhasil disimpan.');
                $this->redirect('transaksi');
            }
        }

        $this->tampilForm('Tambah Transaksi', 'transaksi/tambah', $old, $errors);
    }

    public function edit($id = 0)
    {
        $id = (int) $id;
        $row = $this->model->find($id);
        if (!$row) {
            flash('danger', 'Transaksi tidak ditemukan.');
            $this->redirect('transaksi');
        }

        $errors = [];
        $old = [
            'trans_id_pelanggan' => $row['trans_id_pelanggan'],
            'trans_id_layanan'   => $row['trans_id_layanan'],
            'trans_tgl_masuk'    => $row['trans_tgl_masuk'],
            'trans_tgl_selesai'  => $row['trans_tgl_selesai'] ?? '',
            'trans_berat'        => $row['trans_berat'],
        ];

        if ($this->isPost()) {
            csrf_check();
            [$old, $errors] = $this->validasi();
            if (!$errors) {
                $this->model->update($id, $this->siapkan($old));
                flash('success', 'Transaksi berhasil diperbarui.');
                $this->redirect('transaksi');
            }
        }

        $this->tampilForm('Edit Transaksi', 'transaksi/edit/' . $id, $old, $errors);
    }

    public function hapus()
    {
        if (!$this->isPost()) {
            $this->redirect('transaksi');
        }
        csrf_check();

        $this->model->delete((int) ($_POST['id'] ?? 0));
        flash('success', 'Transaksi berhasil dihapus.');
        $this->redirect('transaksi');
    }

    private function tampilForm(string $title, string $action, array $old, array $errors): void
    {
        $this->view('transaksi/form', [
            'title'     => $title,
            'action'    => $action,
            'old'       => $old,
            'errors'    => $errors,
            'daftarPel' => (new Pelanggan())->all(),
            'daftarLay' => (new Layanan())->all(),
        ]);
    }

    // Ubah input form menjadi data yang siap disimpan
    private function siapkan(array $old): array
    {
        return [
            'trans_id_pelanggan' => (int) $old['trans_id_pelanggan'],
            'trans_id_layanan'   => (int) $old['trans_id_layanan'],
            'trans_tgl_masuk'    => $old['trans_tgl_masuk'],
            'trans_tgl_selesai'  => $old['trans_tgl_selesai'] === '' ? null : $old['trans_tgl_selesai'],
            'trans_berat'        => (int) $old['trans_berat'],
        ];
    }

    private function validasi(): array
    {
        $d = [
            'trans_id_pelanggan' => trim($_POST['trans_id_pelanggan'] ?? ''),
            'trans_id_layanan'   => trim($_POST['trans_id_layanan'] ?? ''),
            'trans_tgl_masuk'    => trim($_POST['trans_tgl_masuk'] ?? ''),
            'trans_tgl_selesai'  => trim($_POST['trans_tgl_selesai'] ?? ''),
            'trans_berat'        => trim($_POST['trans_berat'] ?? ''),
        ];
        $errors = [];

        if (!ctype_digit($d['trans_id_pelanggan']) || !(new Pelanggan())->find((int) $d['trans_id_pelanggan'])) {
            $errors[] = 'Pelanggan tidak valid.';
        }
        if (!ctype_digit($d['trans_id_layanan']) || !(new Layanan())->find((int) $d['trans_id_layanan'])) {
            $errors[] = 'Layanan tidak valid.';
        }
        if (!valid_date($d['trans_tgl_masuk'])) {
            $errors[] = 'Tanggal masuk tidak valid.';
        }
        if ($d['trans_tgl_selesai'] !== '') {
            if (!valid_date($d['trans_tgl_selesai'])) {
                $errors[] = 'Tanggal selesai tidak valid.';
            } elseif (valid_date($d['trans_tgl_masuk']) && $d['trans_tgl_selesai'] < $d['trans_tgl_masuk']) {
                $errors[] = 'Tanggal selesai tidak boleh sebelum tanggal masuk.';
            }
        }
        if (!ctype_digit($d['trans_berat']) || (int) $d['trans_berat'] <= 0) {
            $errors[] = 'Berat harus berupa angka bulat lebih dari 0 (kg).';
        }

        return [$d, $errors];
    }
}
