<?php

spl_autoload_register(function (string $class) {
    $file_path = dirname(__FILE__, 3) . "\\{$class}.php";

    if (file_exists($file_path)) {
        require_once $file_path;
    }
});
