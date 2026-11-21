<?php

// ---- Pengaturan database (sesuaikan dengan XAMPP Anda) ----
define('DB_HOST', 'localhost');
define('DB_NAME', 'quis_laundry');
define('DB_USER', 'root');
define('DB_PASS', '');

define('APP_NAME', 'Laundry Kita');

// Alamat folder aplikasi, terdeteksi otomatis (aman untuk folder berspasi / port 8080)
$base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
define('BASE_URL', implode('/', array_map('rawurlencode', explode('/', $base))));
