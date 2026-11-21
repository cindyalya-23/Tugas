<?php

class Pelanggan extends Model
{
    protected string $table = 'tb_pelanggan';
    protected string $pk = 'pel_id';
    protected array $fields = ['pel_nama', 'pel_alamat', 'pel_hp'];
}
