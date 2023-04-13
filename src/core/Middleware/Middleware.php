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

    public function resolve($key)
    {
        if (is_null($key)) {
            return;
        }

        if (!array_key_exists($key, $this->map)) {
            throw new Exception('Middleware with key "'.$key.'" not defined');
        }

        (new $this->map[$key])->handle();
        return;
    }
}
