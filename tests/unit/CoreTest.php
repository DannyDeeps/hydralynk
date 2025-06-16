<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pingtree\Core;

final class CoreTest extends TestCase {
  public function testGetOuput(): void {
    $this->assertEquals('This is output', (new Core)->getOutput());
  }
}
