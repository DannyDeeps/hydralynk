<?php declare(strict_types=1);

namespace Pingtree\Dashboard;

use Pingtree\Core\Routing\Router;

final class DashboardRoutes {
  public static function register(Router $router): void {
    $router->addRoute('GET', '/', DashboardController::class, 'index');
  }
}