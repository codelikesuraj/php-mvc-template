<?php

use App\Controllers\GreetController;
use App\Helpers\Route;

return [
    /*
     * Application routes go here
     * 
     * At the moment, only POST & GET
     * have been taken into
     * consideration.
     */
    Route::get('/', view('welcome')),
    Route::get('/greet', function () {
        echo 'Hello there, hope you are having a great day!';
    }),
    Route::get('/greet/{:name}', [GreetController::class, 'byName']),
];
