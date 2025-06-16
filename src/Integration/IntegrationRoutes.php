<?php declare(strict_types=1);

namespace Pingtree\Integration;

use Pingtree\Core\Routing\Router;

final class IntegrationRoutes {
  public static function register(Router $router): void {
    $router->addRoute('GET', '/integrations', IntegrationViewController::class, 'index');
  }
}