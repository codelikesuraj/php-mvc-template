<?php

namespace Core\Middleware;

use Exception;

class Middleware
{
    public const MIDDLEWARE_FILE = __DIR__ . '/../../app/Config/middleware.php';
    public array $map;

    public function __construct()
    {
        $this->map = file_exists(self::MIDDLEWARE_FILE) ? require_once(self::MIDDLEWARE_FILE) : [];
    }

    public function resolve($keys = null)
    {
        if (is_null($keys)) {
            return;
        }

        if (is_string($keys)) {
            $keys = [$keys];
        }

        if (count($keys) < 1) {
            return;
        }

        if (!is_array($keys)) {
            throw new Exception('Middlewares should be supplied as an array');
        }

        foreach ($keys as $key) {
            if (!array_key_exists($key, $this->map)) {
                throw new Exception('Middleware with key "' . $key . '" not defined');
            }
        }

        foreach ($keys as $key) {
            (new $this->map[$key])->handle();
        }

        return;
    }
}
