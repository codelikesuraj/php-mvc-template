<?php

declare(strict_types=1);

use Core\Route;
use Dotenv\Dotenv;

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__."/../src/core/helper.php");

// load env variables
$dotenv = Dotenv::createImmutable(__DIR__."/../");
$dotenv->safeLoad();

// load registered routes
$router = new Route();
$router->addRoutes(require_once(__DIR__ . "/../src/app/routes.php"));
$router->run();
