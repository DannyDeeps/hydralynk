<?php

declare(strict_types=1);

namespace Pingtree\Payload\Formats;

use \SimpleXMLElement;

final class XmlPayload extends AbstractPayload {
  public function stringify(): string {
    $xml = new SimpleXMLElement('<xml></xml>');
    return $xml->asXML();
  }
}
