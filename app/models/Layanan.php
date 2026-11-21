<?php

class Layanan extends Model
{
    protected string $table = 'tb_layanan';
    protected string $pk = 'lay_id';
    protected array $fields = ['lay_jenis', 'lay_harga'];

    public function all(): array
    {
        return $this->db->query("SELECT * FROM tb_layanan ORDER BY lay_id ASC")->fetchAll();
    }
}
