<?php declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

use Pingtree\Core\Routing\Router;
use Pingtree\Dashboard\DashboardRoutes;
use Pingtree\Payload\PayloadRoutes;
use Pingtree\Integration\IntegrationRoutes;

$router = new Router;

DashboardRoutes::register($router);
PayloadRoutes::register($router);
IntegrationRoutes::register($router);

$router->dispatch(
  $_SERVER['REQUEST_METHOD'],
  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);