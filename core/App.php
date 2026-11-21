<?php

// Router: index.php?url=controller/method/param1/param2
class App
{
    public function __construct()
    {
        $url = trim((string) ($_GET['url'] ?? ''), '/');
        $parts = $url === '' ? [] : explode('/', $url);

        $name = strtolower($parts[0] ?? 'dashboard');
        $method = $parts[1] ?? 'index';
        $params = array_slice($parts, 2);

        if (!preg_match('/^[a-z]+$/', $name) || !preg_match('/^[a-zA-Z_]+$/', $method)) {
            $this->notFound();
            return;
        }

        $class = ucfirst($name) . 'Controller';
        if (!is_file(ROOT . 'app/controllers/' . $class . '.php')) {
            $this->notFound();
            return;
        }

        define('CURRENT_PAGE', $name);
        $controller = new $class();

        // Hanya method public milik controller itu sendiri yang boleh dipanggil dari URL
        if (!method_exists($controller, $method)) {
            $this->notFound();
            return;
        }
        $ref = new ReflectionMethod($controller, $method);
        if (!$ref->isPublic() || $ref->isConstructor() || $ref->getDeclaringClass()->getName() !== $class) {
            $this->notFound();
            return;
        }

        call_user_func_array([$controller, $method], $params);
    }

    private function notFound(): void
    {
        http_response_code(404);
        if (!defined('CURRENT_PAGE')) {
            define('CURRENT_PAGE', '');
        }
        $title = 'Halaman tidak ditemukan';
        ob_start();
        require ROOT . 'app/views/errors/404.php';
        $content = ob_get_clean();
        require ROOT . 'app/views/layouts/guest.php';
    }
}
