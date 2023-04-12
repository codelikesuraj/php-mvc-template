<?php

declare(strict_types=1);

use App\Helpers\Route;

require_once(__DIR__ . "/../vendor/autoload.php");
require_once(__DIR__."/../src/Helpers/helper.php");

$router = new Route();
$router->addRoutes(require_once(__DIR__ . "/../src/routes.php"));
$router->run();
