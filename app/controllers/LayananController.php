<?php

class LayananController extends Controller
{
    private Layanan $model;

    public function __construct()
    {
        $this->requireLogin();
        $this->model = new Layanan();
    }

    public function index()
    {
        $this->view('layanan/index', ['title' => 'Layanan', 'rows' => $this->model->all()]);
    }

    public function tambah()
    {
        $errors = [];
        $old = ['lay_jenis' => '', 'lay_harga' => ''];

        if ($this->isPost()) {
            csrf_check();
            [$old, $errors] = $this->validasi();
            if (!$errors) {
                $this->model->create($old);
                flash('success', 'Layanan baru berhasil ditambahkan.');
                $this->redirect('layanan');
            }
        }

        $this->view('layanan/form', [
            'title' => 'Tambah Layanan', 'action' => 'layanan/tambah', 'old' => $old, 'errors' => $errors,
        ]);
    }

    public function edit($id = 0)
    {
        $id = (int) $id;
        $row = $this->model->find($id);
        if (!$row) {
            flash('danger', 'Data layanan tidak ditemukan.');
            $this->redirect('layanan');
        }

        $errors = [];
        $old = $row;

        if ($this->isPost()) {
            csrf_check();
            [$old, $errors] = $this->validasi();
            if (!$errors) {
                $this->model->update($id, $old);
                flash('success', 'Data layanan berhasil diperbarui.');
                $this->redirect('layanan');
            }
        }

        $this->view('layanan/form', [
            'title' => 'Edit Layanan', 'action' => 'layanan/edit/' . $id, 'old' => $old, 'errors' => $errors,
        ]);
    }

    public function hapus()
    {
        if (!$this->isPost()) {
            $this->redirect('layanan');
        }
        csrf_check();

        try {
            $this->model->delete((int) ($_POST['id'] ?? 0));
            flash('success', 'Data layanan berhasil dihapus.');
        } catch (PDOException $e) {
            flash('danger', 'Layanan tidak bisa dihapus karena sudah dipakai pada transaksi.');
        }
        $this->redirect('layanan');
    }

    private function validasi(): array
    {
        $jenis = trim($_POST['lay_jenis'] ?? '');
        $harga = trim($_POST['lay_harga'] ?? '');
        $errors = [];

        if ($jenis === '') {
            $errors[] = 'Jenis layanan wajib diisi.';
        } elseif (mb_strlen($jenis) > 100) {
            $errors[] = 'Jenis layanan maksimal 100 karakter.';
        }
        if ($harga === '' || !ctype_digit($harga) || (int) $harga <= 0) {
            $errors[] = 'Harga harus berupa angka lebih dari 0.';
        }

        return [['lay_jenis' => $jenis, 'lay_harga' => $harga === '' ? '' : $harga], $errors];
    }
}
