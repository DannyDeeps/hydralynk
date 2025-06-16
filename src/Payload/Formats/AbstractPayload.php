<?php

declare(strict_types=1);

namespace Pingtree\Payload\Formats;

abstract class AbstractPayload {
  protected array $props = [];

  public function setProperty(string $prop, string|float $value): void {
    $this->props[$prop] = $value;
  }

  public function getProperty(string $prop): string|float {
    return $this->props[$prop] ?? null;
  }

  abstract public function stringify(): string;
}
