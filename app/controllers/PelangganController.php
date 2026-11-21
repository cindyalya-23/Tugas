<?php

class PelangganController extends Controller
{
    private Pelanggan $model;

    public function __construct()
    {
        $this->requireLogin();
        $this->model = new Pelanggan();
    }

    public function index()
    {
        $this->view('pelanggan/index', ['title' => 'Pelanggan', 'rows' => $this->model->all()]);
    }

    public function tambah()
    {
        $errors = [];
        $old = ['pel_nama' => '', 'pel_alamat' => '', 'pel_hp' => ''];

        if ($this->isPost()) {
            csrf_check();
            [$old, $errors] = $this->validasi();
            if (!$errors) {
                $this->model->create($old);
                flash('success', 'Pelanggan baru berhasil ditambahkan.');
                $this->redirect('pelanggan');
            }
        }

        $this->view('pelanggan/form', [
            'title' => 'Tambah Pelanggan', 'action' => 'pelanggan/tambah', 'old' => $old, 'errors' => $errors,
        ]);
    }

    public function edit($id = 0)
    {
        $id = (int) $id;
        $row = $this->model->find($id);
        if (!$row) {
            flash('danger', 'Data pelanggan tidak ditemukan.');
            $this->redirect('pelanggan');
        }

        $errors = [];
        $old = $row;

        if ($this->isPost()) {
            csrf_check();
            [$old, $errors] = $this->validasi();
            if (!$errors) {
                $this->model->update($id, $old);
                flash('success', 'Data pelanggan berhasil diperbarui.');
                $this->redirect('pelanggan');
            }
        }

        $this->view('pelanggan/form', [
            'title' => 'Edit Pelanggan', 'action' => 'pelanggan/edit/' . $id, 'old' => $old, 'errors' => $errors,
        ]);
    }

    public function hapus()
    {
        if (!$this->isPost()) {
            $this->redirect('pelanggan');
        }
        csrf_check();

        try {
            $this->model->delete((int) ($_POST['id'] ?? 0));
            flash('success', 'Data pelanggan berhasil dihapus.');
        } catch (PDOException $e) {
            flash('danger', 'Pelanggan tidak bisa dihapus karena sudah dipakai pada transaksi.');
        }
        $this->redirect('pelanggan');
    }

    private function validasi(): array
    {
        $data = [
            'pel_nama'   => trim($_POST['pel_nama'] ?? ''),
            'pel_alamat' => trim($_POST['pel_alamat'] ?? ''),
            'pel_hp'     => trim($_POST['pel_hp'] ?? ''),
        ];
        $errors = [];

        if ($data['pel_nama'] === '') {
            $errors[] = 'Nama wajib diisi.';
        } elseif (mb_strlen($data['pel_nama']) > 100) {
            $errors[] = 'Nama maksimal 100 karakter.';
        }
        if (mb_strlen($data['pel_hp']) > 30) {
            $errors[] = 'No. HP maksimal 30 karakter.';
        } elseif ($data['pel_hp'] !== '' && !preg_match('/^[0-9+\-\s]+$/', $data['pel_hp'])) {
            $errors[] = 'No. HP hanya boleh berisi angka, spasi, + dan -.';
        }

        return [$data, $errors];
    }
}
