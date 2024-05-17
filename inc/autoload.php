<?php

spl_autoload_register(function ($name) {
    $file = str_replace('\\', '/', __DIR__ . "/$name.php");

    if (file_exists($file)) {
        require_once $file;
    }
});
