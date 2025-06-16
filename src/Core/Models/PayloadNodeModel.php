<?php

declare(strict_types=1);

namespace Pingtree\Core\Models;

use \PDO;

class PayloadNodeModel extends AbstractModel {
  public static function create(
    int $payloadId,
    string $name,
    string $value,
    string $type,
    ?int $parentId = null,
  ): array|false {
    $db = self::connect();

    $payloadNode = false;

    try {
      $stmt = $db->prepare(
        "INSERT INTO payload_nodes (
          payload_id,
          name,
          value,
          type,
          parent_id
        ) VALUES (
          :payload_id,
          :name,
          :value,
          :type,
          :parent_id
        ) RETURNING *;"
      );

      $stmt->execute([
        ':payload_id' => $payloadId,
        ':name'       => $name,
        ':value'      => $value,
        ':type'       => $type,
        ':parent_id'  => $parentId
      ]);

      $payloadNode = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\Throwable $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
    }

    return $payloadNode;
  }

  public static function read(int $id): array|false {
    $db = self::connect();

    $payloadNode = false;

    try {
      $stmt = $db->prepare("SELECT * FROM payload_nodes WHERE id = :id");
      $stmt->execute([':id' => $id]);

      $payloadNode = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
    }

    return $payloadNode;
  }

  public static function update(int $id, array $fields): array|false {
    if (empty($fields)) return false;

    $db = self::connect();

    $payloadNode = false;

    try {
      $placeholders = implode(',', array_map(fn($field) => "$field = :$field", array_keys($fields)));
      $values = array_combine(
        array_map(fn($key) => ":$key", array_keys($fields)),
        array_values($fields)
      );

      $stmt = $db->prepare("UPDATE payload_nodes SET $placeholders, modified_at = CURRENT_TIMESTAMP WHERE id = :id RETURNING *");
      $stmt->execute(array_merge($values, [':id' => $id]));

      $payloadNode = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
    }

    return $payloadNode;
  }

  public static function delete(int $id): array|false {
    $db = self::connect();

    $payloadNode = false;

    try {
      $stmt = $db->prepare('DELETE FROM payload_nodes WHERE id = :id RETURNING *');
      $stmt->execute([':id' => $id]);

      $payloadNode = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
    }

    return $payloadNode;
  }

  public static function all(): array {
    $db = self::connect();
    $all = [];

    try {
      $stmt = $db->query('SELECT * FROM payload_nodes');
      $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
    }

    return $all;
  }

  public static function count(): int {
    $db = self::connect();
    $count = 0;

    try {
      $stmt = $db->query('SELECT COUNT(*) FROM payload_nodes');
      $count = $stmt->fetchColumn();
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
    }

    return $count;
  }

  public static function truncate(): bool {
    $db = self::connect();

    try {
      $db->query('DELETE FROM payload_nodes');
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
      return false;
    }

    return true;
  }
}