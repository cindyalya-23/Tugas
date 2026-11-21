<?php

// Login, daftar akun baru, dan logout (halaman ini boleh diakses tanpa login)
class AuthController extends Controller
{
    public function index()
    {
        $this->redirect('auth/login');
    }

    public function login()
    {
        if (is_login()) {
            $this->redirect('dashboard');
        }

        $error = '';
        $username = '';

        if ($this->isPost()) {
            csrf_check();
            $username = trim($_POST['user_name'] ?? '');
            $password = $_POST['user_password'] ?? '';

            if ((new User())->login($username, $password)) {
                $this->redirect('dashboard');
            }
            $error = 'Username atau password salah, atau akun tidak aktif.';
        }

        $this->view('auth/login', ['title' => 'Login', 'error' => $error, 'username' => $username], 'guest');
    }

    public function register()
    {
        if (is_login()) {
            $this->redirect('dashboard');
        }

        $errors = [];
        $old = ['user_name' => '', 'user_namalengkap' => ''];

        if ($this->isPost()) {
            csrf_check();
            $old['user_name'] = trim($_POST['user_name'] ?? '');
            $old['user_namalengkap'] = trim($_POST['user_namalengkap'] ?? '');
            $password = $_POST['user_password'] ?? '';
            $konfirmasi = $_POST['konfirmasi'] ?? '';

            $user = new User();

            if (!preg_match('/^[A-Za-z0-9_.]{3,50}$/', $old['user_name'])) {
                $errors[] = 'Username 3-50 karakter, hanya huruf, angka, titik, dan underscore.';
            } elseif ($user->usernameAda($old['user_name'])) {
                $errors[] = 'Username sudah dipakai, silakan pilih yang lain.';
            }
            if ($old['user_namalengkap'] === '' || mb_strlen($old['user_namalengkap']) > 100) {
                $errors[] = 'Nama lengkap wajib diisi (maksimal 100 karakter).';
            }
            if (strlen($password) < 6) {
                $errors[] = 'Password minimal 6 karakter.';
            } elseif ($password !== $konfirmasi) {
                $errors[] = 'Konfirmasi password tidak sama.';
            }

            if (!$errors) {
                try {
                    $user->register($old['user_name'], $password, $old['user_namalengkap']);
                    flash('success', 'Akun berhasil dibuat. Silakan login.');
                    $this->redirect('auth/login');
                } catch (PDOException $e) {
                    if ($e->getCode() !== '23000') {
                        throw $e;
                    }
                    $errors[] = 'Username sudah dipakai, silakan pilih yang lain.';
                }
            }
        }

        $this->view('auth/register', ['title' => 'Daftar', 'errors' => $errors, 'old' => $old], 'guest');
    }

    public function logout()
    {
        if ($this->isPost()) {
            csrf_check();
            $_SESSION = [];
            session_destroy();
            session_start();
            flash('success', 'Anda sudah logout.');
        }
        $this->redirect('auth/login');
    }
}
