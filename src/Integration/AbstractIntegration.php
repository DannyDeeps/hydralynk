<?php declare(strict_types=1);

namespace Pingtree\Integrations;

abstract class AbstractIntegration {
  private string $endpoint;

  public function setEndpoint(string $endpoint): void {
    $this->endpoint = $endpoint;
  }

  public function prepareHandle(): void {
    $ch = curl_init();

    curl_setopt_array($ch, [
      CURLOPT_URL => $this->endpoint,
      CURLOPT_RETURNTRANSFER, true
    ]);
  }
}