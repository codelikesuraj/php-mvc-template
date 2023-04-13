<?php

declare(strict_types=1);

use Core\Route;
use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager;

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/../src/core/helper.php");

// load env variables
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->safeLoad();

// load schema
$schema = new Manager();
$schema->addConnection([
    "driver" => "mysql",
    "host" => config('db.host'),
    "database" => config('db.database'),
    "username" => config('db.username'),
    "password" => config('db.password')
]);
$schema->setAsGlobal();
$schema->bootEloquent();

// load registered routes
$router = new Route();
$router->addRoutes(require_once(__DIR__ . "/../src/app/routes.php"));
$router->run();
