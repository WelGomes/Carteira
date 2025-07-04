<?php

spl_autoload_register(function (string $class) {
    $path = dirname(__FILE__, 3);
    $file_path = $path . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . ".php";

    if (file_exists($file_path)) {
        require_once $file_path;
    }
});
