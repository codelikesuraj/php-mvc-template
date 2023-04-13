<?php

declare(strict_types=1);

use Core\Route;
use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager;

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__ . "/../src/core/helper.php");

session_start();

// load env variables
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->safeLoad();

// load schema/database configurations
$schema = new Manager;
foreach(database() as $key => $value) {
    $schema->addConnection($value, $key);
}
$schema->setAsGlobal();
$schema->bootEloquent();

// load registered routes
$router = new Route();
$router->addRoutes(require_once(__DIR__ . "/../src/app/routes.php"));
$router->run();
