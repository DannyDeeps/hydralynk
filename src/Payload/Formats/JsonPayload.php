<?php

declare(strict_types=1);

namespace Pingtree\Payload\Formats;

final class JsonPayload extends AbstractPayload {
  public function stringify(): string {
    return json_encode($this->props);
  }
}
