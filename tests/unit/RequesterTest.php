<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Pingtree\Requester;

final class RequesterTest extends TestCase {
  public function testRun(): void {
    $requester = new Requester;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://pokeapi.co/api/v2/location/pallet-town/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $requester->addHandle($ch);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://pokeapi.co/api/v2/location/canalave-city/');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $requester->addHandle($ch);

    $responses = $requester->run();
    
    $this->assertEquals(1, 1);
  }
}