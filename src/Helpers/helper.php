<?php

// abort execution with status code

use App\Helpers\View;

if (!function_exists('abort')) {
    function abort($code = 404)
    {
        header("HTTP/1.0 404 Not Found");
        die('ERROR 404: Page not found');
    }
}

// helper for View class
if (!function_exists('view')) {
    function view(string $file, array $with = []) {
        return new View($file, $with);
    }
}
