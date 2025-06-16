<?php

declare(strict_types=1);

namespace Pingtree\Core;

use \CurlHandle;

final class Requester {
  private array $handles = [];

  public function addHandle(CurlHandle $handle): void {
    $this->handles[] = $handle;
  }

  public function run(): array {
    // echo count($this->handles);

    $mh = curl_multi_init();

    foreach ($this->handles as $handle) {
      curl_multi_add_handle($mh, $handle);
    }

    do {
      curl_multi_exec($mh, $unfinishedHandles);
      curl_multi_select($mh);
    } while ($unfinishedHandles > 0);

    $responses = [];

    foreach ($this->handles as $ch) {
      $content = curl_multi_getcontent($ch);
      if ($content) {
        $responses[] = [
          'content' => json_validate($content) ? json_decode($content, true) : 'invalid json',
          'error' => curl_error($ch),
          'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE)
        ];
      }

      curl_multi_remove_handle($mh, $ch);
      curl_close($ch);
    }

    curl_multi_close($mh);

    // echo count($responses);

    return $responses;
  }
}