<?php declare(strict_types=1);

namespace Pingtree\Payload;

use Pingtree\Core\Routing\Router;

final class PayloadRoutes {
  public static function register(Router $router): void {
    $router->addRoute('GET', '/payloads', PayloadViewController::class, 'payloads');
    $router->addRoute('GET', '/payload/edit/#id', PayloadViewController::class, 'editPayload');

    $router->addRoute('GET', '/api/payloads', PayloadApiController::class, 'all');
    $router->addRoute('GET', '/api/payload/#id', PayloadApiController::class, 'read');
    $router->addRoute('GET', '/api/payload/#id/nodes', PayloadApiController::class, 'readWithNodes');
    $router->addRoute('POST', '/api/payload', PayloadApiController::class, 'create');
    $router->addRoute('PUT', '/api/payload/#id', PayloadApiController::class, 'update');
    $router->addRoute('DELETE', '/api/payload/#id', PayloadApiController::class, 'delete');

    $router->addRoute('GET', '/api/payload/nodes', Node\NodeApiController::class, 'all');
    $router->addRoute('GET', '/api/payload/node/#id', Node\NodeApiController::class, 'read');
    $router->addRoute('POST', '/api/payload/node', Node\NodeApiController::class, 'create');
    $router->addRoute('PUT', '/api/payload/node/#id', Node\NodeApiController::class, 'update');
    $router->addRoute('DELETE', '/api/payload/node/#id', Node\NodeApiController::class, 'delete');
  }
}