<?php

/* 
 * set your custom database
 * configurations here
 */


return [
    /* always have a default connection */
    'default' => [
        "driver" => "mysql",
        "host" => config('db.host'),
        "database" => config('db.database'),
        "username" => config('db.username'),
        "password" => config('db.password')
    ],

    /* add yours below */
];
