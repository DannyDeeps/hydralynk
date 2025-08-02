<?php declare(strict_types=1);

namespace Pingtree\Payload\Node;

use Pingtree\Core\Models\PayloadNodeModel;
use Pingtree\Core\Template\TemplateController;
use Pingtree\Core\Routing\{ Route, ApiController };

final class NodeApiController extends ApiController {
  public static function read(Route $route): void {
    try {
      $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      $node = PayloadNodeModel::read($route->params['id']);
      if (!$node) {
        if ($wantsHtml) {
          parent::htmlResponse('', 404);
        } else {
          parent::jsonResponse([], 404);
        }

        return;
      }

      if ($wantsHtml) {
        parent::htmlResponse(
          new TemplateController()->engine
            ->render('shards/node', [ 'node' => $node ])
        );
      } else {
        parent::jsonResponse($node);
      }
    } catch (\Throwable $e) {
      parent::jsonResponse([], 500);
    }
  }

  public static function create(Route $route): void {
    try {
      $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
        $data = parent::parseFormRequest();
      } else {
        $data = parent::parseJsonRequest();
      }

      $newNode = PayloadNodeModel::create(...$data);
      if (!$newNode) {
        if ($wantsHtml) {
          parent::htmlResponse('', 500);
        } else {
          parent::jsonResponse([], 500);
        }
      }

      if ($wantsHtml) {
        parent::htmlResponse(
          new TemplateController()->engine
            ->render('shards/node', [ 'node' => $newNode ])
        );
      } else {
        parent::jsonResponse($newNode);
      }
    } catch (\Throwable $e) {
      parent::jsonResponse(print_r($e, true), 500);
      // parent::jsonResponse(['error' => print_r($e, true)], 500);
    }
  }

  public static function update(Route $route): void {
    try {
      $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      $data = json_decode(file_get_contents('php://input'), true);

      $id = $route->params['id'];
      unset($data['id']);

      $updatedNode = PayloadNodeModel::update($id, $data);
      if (!$updatedNode) {
        if ($wantsHtml) {
          parent::htmlResponse('', 404);
        } else {
          parent::jsonResponse([], 404);
        }
      }

      if ($wantsHtml) {
        parent::htmlResponse(
          new TemplateController()->engine
            ->render('shards/node', [ 'node' => $updatedNode ])
        );
      } else {
        parent::jsonResponse($updatedNode);
      }
    } catch (\Throwable $e) {
      // d($e->getMessage());
      parent::jsonResponse([], 500);
    }
  }

  public static function delete(Route $route): void {
    try {
      $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      $deletedNode = PayloadNodeModel::delete($route->params['id']);
      if (!$deletedNode) {
        if ($wantsHtml) {
          parent::htmlResponse('', 404);
        } else {
          parent::jsonResponse([], 404);
        }
      }

      if ($wantsHtml) {
        parent::htmlResponse('', 200);
      } else {
        parent::jsonResponse($deletedNode, 200);
      }
    } catch (\Throwable $e) {
      // d($e->getMessage());
      parent::jsonResponse([], 500);
    }
  }

  public static function all(Route $route): void {
    try {
      $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      $nodes = PayloadNodeModel::all();
      if (!$nodes) {
        if ($wantsHtml) {
          parent::htmlResponse('', 404);
        } else {
          parent::jsonResponse([], 404);
        }
      }

      if ($wantsHtml) {
        parent::htmlResponse(
          new TemplateController()->engine
            ->render('shards/nodes', [ 'nodes' => $nodes ])
        );
      } else {
        parent::jsonResponse($nodes);
      }
    } catch (\Throwable $e) {
      // d($e->getMessage());
      parent::jsonResponse([], 500);
    }
  }
}