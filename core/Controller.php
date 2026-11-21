<?php

abstract class Controller
{
    protected function view(string $view, array $data = [], string $layout = 'main'): void
    {
        extract($data);

        ob_start();
        require ROOT . 'app/views/' . $view . '.php';
        $content = ob_get_clean();

        require ROOT . 'app/views/layouts/' . $layout . '.php';
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . url($path));
        exit;
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    // Halaman yang dilindungi: wajib login
    protected function requireLogin(): void
    {
        if (!is_login()) {
            $this->redirect('auth/login');
        }
    }
}
