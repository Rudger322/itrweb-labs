<?php

spl_autoload_register(function ($class) {

    // Убираем начальный \
    $class = ltrim($class, '\\');

    // namespace и _ → /
    $file = str_replace(
        ['\\', '_'],
        DIRECTORY_SEPARATOR,
        $class
    );

    $file = __DIR__ . '/src/' . $file . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});