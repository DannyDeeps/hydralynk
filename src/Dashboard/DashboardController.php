<?php declare(strict_types=1);

namespace Pingtree\Dashboard;

use Pingtree\Core\Models\PayloadNodeModel;
use Pingtree\Core\Models\PayloadModel;
use Pingtree\Core\Template\TemplateController;

final class DashboardController {
  public static function index(): void {
    echo new TemplateController()->engine->render('pages/dashboard', [
      'payloads' => PayloadModel::all(),
      'payloadData' => PayloadNodeModel::all()
    ]);
  }
}