# Laundry Kita - PHP MVC

Sistem informasi laundry sederhana dengan konsep MVC (tanpa framework), PHP + PDO + Bootstrap 5,
sesuai ERD database `quis_laundry` (tb_pelanggan, tb_layanan, tb_transaksi, tb_users).

## Struktur MVC

```
index.php            Front controller (semua request masuk ke sini)
config/config.php    Pengaturan database
core/                App (router), Controller, Model, Database, helpers
app/models/          Pelanggan, Layanan, Transaksi, User  -> akses database
app/controllers/     Auth, Dashboard, Pelanggan, Layanan, Transaksi -> alur logika
app/views/           Tampilan (layouts, auth, dashboard, pelanggan, layanan, transaksi)
database.sql         Struktur tabel + data contoh
```

Routing: `index.php?url=controller/method/parameter`, contoh `index.php?url=pelanggan/edit/3`.

## Cara menjalankan

1. Salin folder ke `htdocs` XAMPP (mis. `htdocs/laundry-mvc`).
2. Start Apache + MySQL, buka phpMyAdmin, **Import** `database.sql`
   (membuat database `crud-oop-php`, tabel, dan data contoh).
3. Sesuaikan `config/config.php` bila user/password MySQL bukan `root` / kosong.
4. Buka `http://localhost/laundry-mvc/` (atau dengan port Anda, mis. `localhost:8080/...`).

## Keamanan

- Semua halaman data wajib login (cek di constructor controller)
- Password di-hash (`password_hash`), query memakai prepared statement (anti SQL injection)
- Output di-escape (anti XSS), form dilindungi token CSRF, hapus data hanya lewat POST
- Session ID diganti saat login, cookie session `HttpOnly`
