<?php

use App\Controllers\GreetController;
use Core\Route;

return [
    /*
     * Application routes go here
     * 
     * At the moment, only POST & GET
     * have been taken into
     * consideration.
     * 
     * USAGE
     * Route::method(path, callback, middleware),
     */

    Route::get('/', view('welcome')),
    Route::get('/greet', function () {
        echo 'Hello there, hope you are having a great day!';
    }),
    Route::get('/greet/{:name}', [GreetController::class, 'byName']),
    Route::get('/env', function () {
        echo config('app.name');
    }),
];
