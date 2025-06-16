<?php declare(strict_types=1);

namespace Pingtree\Integration;

use Pingtree\Core\Template\TemplateController;

final class IntegrationViewController {
  public static function index(): void {
    echo new TemplateController()->engine->render('pages/integrations', []);
  }
}