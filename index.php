<?php

// Front controller: semua request masuk lewat file ini (index.php?url=controller/method/param)

define('ROOT', __DIR__ . DIRECTORY_SEPARATOR);

error_reporting(E_ALL);

require_once ROOT . 'config/config.php';
require_once ROOT . 'core/helpers.php';

session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();

spl_autoload_register(function ($class) {
    foreach (['core', 'app/controllers', 'app/models'] as $dir) {
        $file = ROOT . $dir . '/' . $class . '.php';
        if (is_file($file)) {
            require_once $file;
            return;
        }
    }
});

new App();
