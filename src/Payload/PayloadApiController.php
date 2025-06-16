<?php declare(strict_types=1);

namespace Pingtree\Payload;

use Pingtree\Core\Models\PayloadModel;
use Pingtree\Core\Template\TemplateController;
use Pingtree\Core\Routing\{ Route, ApiController };

final class PayloadApiController extends ApiController {
  public static function read(Route $route): void {
    try {
      $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      $payload = PayloadModel::read($route->params['id']);
      if (!$payload) {
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
            ->render('shards/payload', [ 'payload' => $payload ])
        );
      } else {
        parent::jsonResponse($payload);
      }
    } catch (\Throwable $e) {
      parent::jsonResponse([], 500);
    }
  }

  public static function readWithNodes(Route $route): void {
    try {
      $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      $payload = PayloadModel::readWithNodes($route->params['id']);
      if (!$payload) {
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
            ->render('shards/payload', [ 'payload' => $payload ])
        );
      } else {
        parent::jsonResponse($payload);
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

      $newPayload = PayloadModel::create(...$data);
      if (!$newPayload) {
        if ($wantsHtml) {
          parent::htmlResponse('', 500);
        } else {
          parent::jsonResponse([], 500);
        }

        return;
      }

      if ($wantsHtml) {
        parent::htmlResponse(
          new TemplateController()->engine
            ->render('shards/payload', [ 'payload' => $newPayload ])
        );
      } else {
        parent::jsonResponse($newPayload);
      }
    } catch (\Throwable $e) {
      parent::jsonResponse(['error' => print_r($e, true)], 500);
    }
  }

  public static function update(Route $route): void {
    try {
      $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      $data = json_decode(file_get_contents('php://input'), true);

      $id = $route->params['id'];
      unset($data['id']);

      $updatedPayload = PayloadModel::update($id, $data);
      if (!$updatedPayload) {
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
            ->render('shards/payload', [ 'payload' => $updatedPayload ])
        );
      } else {
        parent::jsonResponse($updatedPayload);
      }
    } catch (\Throwable $e) {
      // d($e->getMessage());
      parent::jsonResponse([], 500);
    }
  }

  public static function delete(Route $route): void {
    try {
      $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      $deletedPayload = PayloadModel::delete($route->params['id']);
      if (!$deletedPayload) {
        if ($wantsHtml) {
          parent::htmlResponse('', 404);
        } else {
          parent::jsonResponse([], 404);
        }

        return;
      }

      if ($wantsHtml) {
        parent::htmlResponse('', 200);
      } else {
        parent::jsonResponse($deletedPayload, 200);
      }
    } catch (\Throwable $e) {
      // d($e->getMessage());
      parent::jsonResponse([], 500);
    }
  }

  public static function all(): void {
    try {
      $wantsHtml = 'text/html' === ($_SERVER['HTTP_ACCEPT'] ?? '');

      $payloads = PayloadModel::all();
      if (!$payloads) {
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
            ->render('shards/payloads', [ 'payloads' => $payloads ])
        );
      } else {
        parent::jsonResponse($payloads);
      }
    } catch (\Throwable $e) {
      // d($e->getMessage());
      parent::jsonResponse([], 500);
    }
  }
}