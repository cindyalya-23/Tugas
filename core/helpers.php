<?php

function e($v): string
{
    return htmlspecialchars((string) ($v ?? ''), ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    $path = trim($path, '/');
    return BASE_URL . '/index.php' . ($path !== '' ? '?url=' . $path : '');
}

function flash(string $type, string $msg): void
{
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}

function get_flash(): ?array
{
    if (isset($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

function csrf_check(): void
{
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419);
        die('Token keamanan tidak valid. Silakan kembali dan muat ulang halaman.');
    }
}

function rupiah($n): string
{
    return 'Rp ' . number_format((int) $n, 0, ',', '.');
}

function tgl($d): string
{
    if (!$d) {
        return '-';
    }
    $t = strtotime($d);
    return $t ? date('d/m/Y', $t) : '-';
}

function valid_date(?string $s): bool
{
    if ($s === null || $s === '') {
        return false;
    }
    $d = DateTime::createFromFormat('Y-m-d', $s);
    return $d && $d->format('Y-m-d') === $s;
}

function is_login(): bool
{
    return !empty($_SESSION['user']);
}

function auth_user(): array
{
    return $_SESSION['user'] ?? [];
}
