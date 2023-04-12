<?php

// abort execution with status code

use Core\View;

if (!function_exists('abort')) {
    function abort($code = 404)
    {
        header("HTTP/1.0 404 Not Found");
        die('ERROR 404: Page not found');
    }
}

// helper for View class
if (!function_exists('view')) {
    function view(string $file, array $with = [])
    {
        return new View($file, $with);
    }
}

// helper for getting specific env variables
if (!function_exists('env')) {
    function env($key = null, $default = null)
    {
        if(is_null($key)) {
            return $_ENV;
        }

        if (array_key_exists($key, $_ENV)) {
            return $_ENV[$key];
        }

        return $default;
    }
}

// helper for getting specific config variables
if (!function_exists('config')) {
    function config($key = null, $default = null)
    {
        $key = str_replace('.', '_', trim($key));
        $config = get_config_from_file();
        
        if (is_null($key)) {
            return $config;
        }
        
        if (array_key_exists($key, $config)) {
            return $config[$key];
        }
        
        return $default;
    }
}

// helper for loading all config variables
if (!function_exists('get_config_from_file')) {
    function get_config_from_file()
    {
        $config_file = __DIR__ . '/config.php';
        return file_exists($config_file) ? require_once($config_file) : [];
    }
}
