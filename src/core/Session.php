<?php

namespace Core;

class Session
{
    public function get($key)
    {
        return $_SESSION[$key];
    }

    public function set($key, $value = null)
    {
        $_SESSION[$key] = $value;
    }

    public function has($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    public function all()
    {
        return $_SESSION;
    }

    public function regenerate()
    {
        session_reset();
    }

    public function delete($key)
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

}