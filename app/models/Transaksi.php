<?php

class Transaksi extends Model
{
    protected string $table = 'tb_transaksi';
    protected string $pk = 'trans_id';
    protected array $fields = [
        'trans_id_pelanggan', 'trans_id_layanan', 'trans_tgl_masuk',
        'trans_tgl_selesai', 'trans_berat', 'trans_total',
    ];

    private function baseSelect(): string
    {
        return "SELECT t.*, p.pel_nama, l.lay_jenis, l.lay_harga
                FROM tb_transaksi t
                JOIN tb_pelanggan p ON p.pel_id = t.trans_id_pelanggan
                JOIN tb_layanan l ON l.lay_id = t.trans_id_layanan";
    }

    public function all(): array
    {
        return $this->db->query($this->baseSelect() . " ORDER BY t.trans_id DESC")->fetchAll();
    }

    public function terbaru(int $limit = 5): array
    {
        $limit = max(1, $limit);
        return $this->db->query($this->baseSelect() . " ORDER BY t.trans_id DESC LIMIT $limit")->fetchAll();
    }

    public function pendapatan(): int
    {
        return (int) $this->db->query("SELECT COALESCE(SUM(trans_total), 0) FROM tb_transaksi")->fetchColumn();
    }

    public function belumSelesai(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM tb_transaksi WHERE trans_tgl_selesai IS NULL")->fetchColumn();
    }

    // Total = berat x harga layanan, dihitung di server
    public function hitungTotal(int $layananId, int $berat): int
    {
        $stmt = $this->db->prepare("SELECT lay_harga FROM tb_layanan WHERE lay_id = :id");
        $stmt->execute([':id' => $layananId]);
        return (int) $stmt->fetchColumn() * $berat;
    }

    public function create(array $data): void
    {
        $data['trans_total'] = $this->hitungTotal((int) $data['trans_id_layanan'], (int) $data['trans_berat']);
        parent::create($data);
    }

    public function update(int $id, array $data): void
    {
        $data['trans_total'] = $this->hitungTotal((int) $data['trans_id_layanan'], (int) $data['trans_berat']);
        parent::update($id, $data);
    }
}
