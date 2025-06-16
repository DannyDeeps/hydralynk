<?php declare(strict_types=1);

namespace Pingtree\Core\Template;

use \League\Plates\Engine;
use \League\Plates\Template\Theme;

class TemplateController {
  public Engine $engine;

  public function __construct() {
    $this->engine = Engine::fromTheme(Theme::hierarchy([
      Theme::new(__DIR__ . '/../../templates/default', ' Default')
    ]));
    $this->engine->setFileExtension('phtml');
  }
}