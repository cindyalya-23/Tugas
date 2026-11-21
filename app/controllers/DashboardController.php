<?php

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->requireLogin();
    }

    public function index()
    {
        $transaksi = new Transaksi();

        $this->view('dashboard/index', [
            'title'         => 'Dashboard',
            'jmlPelanggan'  => (new Pelanggan())->count(),
            'jmlLayanan'    => (new Layanan())->count(),
            'jmlTransaksi'  => $transaksi->count(),
            'belumSelesai'  => $transaksi->belumSelesai(),
            'pendapatan'    => $transaksi->pendapatan(),
            'terbaru'       => $transaksi->terbaru(5),
        ]);
    }
}
