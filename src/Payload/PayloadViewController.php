<?php declare(strict_types=1);

namespace Pingtree\Payload;

use Pingtree\Core\Models\PayloadModel;
use Pingtree\Core\Template\TemplateController;
use Pingtree\Core\Routing\Route;

final class PayloadViewController {
  public static function payloads(): void {
    echo new TemplateController()->engine->render('pages/payloads', [
      'payloads' => PayloadModel::all()
    ]);
  }

  public static function editPayload(Route $route): void {
    echo new TemplateController()->engine->render('pages/edit-payload', [
      'payload' => PayloadModel::readWithNodes($route->params['id'])
    ]);
  }
}