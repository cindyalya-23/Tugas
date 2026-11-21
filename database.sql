CREATE DATABASE IF NOT EXISTS `quis_laundry` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `quis_laundry`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS tb_transaksi;
DROP TABLE IF EXISTS tb_pelanggan;
DROP TABLE IF EXISTS tb_layanan;
DROP TABLE IF EXISTS tb_users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE tb_pelanggan (
    pel_id     INT(11)      NOT NULL AUTO_INCREMENT,
    pel_nama   VARCHAR(100) NOT NULL,
    pel_alamat TEXT         DEFAULT NULL,
    pel_hp     VARCHAR(30)  DEFAULT NULL,
    PRIMARY KEY (pel_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tb_layanan (
    lay_id    INT(11)      NOT NULL AUTO_INCREMENT,
    lay_jenis VARCHAR(100) NOT NULL,
    lay_harga INT(11)      NOT NULL,
    PRIMARY KEY (lay_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tb_transaksi (
    trans_id           INT(11) NOT NULL AUTO_INCREMENT,
    trans_id_pelanggan INT(11) NOT NULL,
    trans_id_layanan   INT(11) NOT NULL,
    trans_tgl_masuk    DATE    NOT NULL,
    trans_tgl_selesai  DATE    DEFAULT NULL,
    trans_berat        INT(11) NOT NULL,
    trans_total        INT(11) NOT NULL,
    PRIMARY KEY (trans_id),
    KEY idx_trans_pelanggan (trans_id_pelanggan),
    KEY idx_trans_layanan (trans_id_layanan),
    CONSTRAINT fk_trans_pelanggan FOREIGN KEY (trans_id_pelanggan) REFERENCES tb_pelanggan (pel_id) ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_trans_layanan   FOREIGN KEY (trans_id_layanan)   REFERENCES tb_layanan (lay_id)   ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tb_users (
    user_id          INT(11)      NOT NULL AUTO_INCREMENT,
    user_name        VARCHAR(50)  NOT NULL,
    user_password    VARCHAR(256) NOT NULL,
    user_namalengkap VARCHAR(100) NOT NULL,
    user_aktif       TINYINT(3)   NOT NULL DEFAULT 1,
    PRIMARY KEY (user_id),
    UNIQUE KEY uq_user_name (user_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------- Data awal ----------
INSERT INTO tb_users (user_name, user_password, user_namalengkap, user_aktif) VALUES
('admin', '$6$ajotzXFi.ScC/BLc$YVuwsZXpd.Vook229bmFU9uJ6QpQ3x4FzO7VdQQYEtlJNFN8ULxUHiXrZpSLLd8NIwPeaU5ofbcONhEUYEIw0.', 'Administrator', 1),
('kasir', '$6$/P.kDTyNuClLjfHB$n34AfaSOE/frfn2pI5ELy4Vg8G7fMm1/oZWlXFeBALfTivfAFdDFBi7as3Y0himK/rgqOgxktSO4xM4rSyISq.', 'Kasir Laundry', 1);

INSERT INTO tb_pelanggan (pel_nama, pel_alamat, pel_hp) VALUES
('Ahmad Fauzi',     'Jl. Gatot Subroto No. 12, Medan',        '081234567801'),
('Siti Aisyah',     'Jl. Sisingamangaraja No. 45, Medan',     '081234567802'),
('Budi Santoso',    'Jl. Setia Budi No. 8, Medan',            '081234567803'),
('Dewi Lestari',    'Jl. Williem Iskandar No. 20, Deli Serdang', '081234567804'),
('Rizky Pratama',   'Jl. Karya Wisata No. 3, Medan',          '081234567805'),
('Putri Ramadhani', 'Jl. Merak Jingga No. 15, Medan',         '081234567806');

INSERT INTO tb_layanan (lay_jenis, lay_harga) VALUES
('Cuci Kering',          6000),
('Cuci Setrika',         8000),
('Setrika Saja',         5000),
('Cuci Bed Cover/Selimut', 25000),
('Cuci Express (6 jam)', 12000);

INSERT INTO tb_transaksi (trans_id_pelanggan, trans_id_layanan, trans_tgl_masuk, trans_tgl_selesai, trans_berat, trans_total) VALUES
(1, 1, '2026-11-10', '2026-11-12', 3, 18000),
(2, 2, '2026-11-11', '2026-11-13', 5, 40000),
(3, 3, '2026-11-15', '2026-11-16', 2, 10000),
(4, 2, '2026-11-18', '2026-11-20', 4, 32000),
(5, 4, '2026-11-19', '2026-11-22', 1, 25000),
(1, 5, '2026-11-20', NULL,         3, 36000),
(6, 2, '2026-11-21', NULL,         6, 48000);
