<?php

use Core\Request;
use Core\Response;
use Core\Validation\Validator;
use Core\View;
use Illuminate\Database\Capsule\Manager;

if (!function_exists('abort')) {
    function abort($code = 404)
    {
        if (request()->isJson()) {
            response()->json()->setStatusCode(404)->send();
        } else {
            View::display(view('errors.' . $code));
        }

        exit();
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
        if (is_null($key)) {
            return $_ENV;
        }

        if (array_key_exists($key, $_ENV)) {
            return $_ENV[$key];
        }

        return $default;
    }
}

if (!function_exists('schema')) {
    function schema()
    {
        return new Manager();
    }
}

// helper for getting specific database variables
if (!function_exists('database')) {
    function database(string $key = null)
    {
        $database = get_database_from_file();

        if (array_key_exists($key, $database)) {
            return $database[$key];
        }

        return $database;
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

// helper for loading all database connections
if (!function_exists('get_database_from_file')) {
    function get_database_from_file()
    {
        $database_file = __DIR__ . '/../app/Config/database.php';
        return file_exists($database_file) ? require($database_file) : [];
    }
}

// helper for loading all config variables
if (!function_exists('get_config_from_file')) {
    function get_config_from_file()
    {
        $config_file = __DIR__ . '/../app/Config/config.php';
        return file_exists($config_file) ? require($config_file) : [];
    }
}

// helper functon to access validator class
if (!function_exists('validator')) {
    function validator()
    {
        return (new Validator());
    }
}

// helper function to dump content
if (!function_exists('dd')) {
    function dd($data = "", $exit = true)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';

        if ($exit) {
            exit();
        }
    }
}

// helper function to access the Request instance
if (!function_exists('request')) {
    function request()
    {
        return new Request;
    }
}

// helper function to access the Response instance
if (!function_exists('response')) {
    function response()
    {
        return new Response;
    }
}
