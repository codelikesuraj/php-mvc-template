<?php

namespace Core;

use Illuminate\Database\Eloquent\Collection;

class Auth
{
    protected const KEY = 'auth';

    public function user()
    {
        if (session()->has(self::KEY)) {
            return session()->get(self::KEY);
        }

        return null;
    }

    public function login(Collection $collection)
    {
        session()->set(self::KEY, $collection);
    }

    public function logout()
    {
        session()->delete(self::KEY);
    }

    public function isLoggedIn()
    {
        if (session()->has(self::KEY)) {
            return true;
        }

        return false;
    }
}