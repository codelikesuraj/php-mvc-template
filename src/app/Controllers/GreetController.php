<?php

namespace App\Controllers;

class GreetController
{
    public function byName($name)
    {
        echo 'Hello '.$name.', hope you are having a great day!';
    }
}
