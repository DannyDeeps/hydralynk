<?php

declare(strict_types=1);

namespace Pingtree\Core\Models;

use \PDO;

class PayloadModel extends AbstractModel {
  public static function create(string $name, string $type): array|false {
    $db = self::connect();

    $payload = false;

    try {
      $stmt = $db->prepare("INSERT INTO payloads (name, type) VALUES (:name, :type) RETURNING *;");
      $stmt->execute([
        ':name' => $name,
        ':type' => $type
      ]);

      $payload = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
    }

    return $payload;
  }

  public static function read(int $id): array|false {
    $db = self::connect();

    $payload = false;

    try {
      $stmt = $db->prepare("SELECT * FROM payloads WHERE id = :id");
      $stmt->execute([':id' => $id]);

      $payload = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
    }

    return $payload;
  }

  public static function readWithNodes(int $id): array|false {
    $db = self::connect();

    $payloadWithNodes = false;

    try {
      $stmt = $db->prepare(
        "SELECT
          pc.*,
          '[' || GROUP_CONCAT(JSON_OBJECT(
            'id', pcd.id,
            'name', pcd.name,
            'value', pcd.value,
            'type', pcd.type,
            'parent_id', pcd.parent_id,
            'created_at', pcd.created_at,
            'modified_at', pcd.modified_at
          )) || ']' AS `nodes`
        FROM payloads AS pc
        LEFT JOIN payload_nodes AS pcd
          ON pc.id = pcd.payload_id
        WHERE pc.id = :id
        GROUP BY pc.id"
      );
      $stmt->execute([':id' => $id]);

      $payloadWithNodes = $stmt->fetch(PDO::FETCH_ASSOC);
      $payloadWithNodes['nodes'] = json_decode($payloadWithNodes['nodes'], true);
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
    }

    return $payloadWithNodes;
  }

  public static function update(int $id, array $fields): array|false {
    if (empty($fields)) return false;

    $db = self::connect();

    $payload = false;

    try {
      $placeholders = implode(',', array_map(fn($field) => "$field = :$field", array_keys($fields)));
      $values = array_combine(
        array_map(fn($key) => ":$key", array_keys($fields)),
        array_values($fields)
      );

      $stmt = $db->prepare("UPDATE payloads SET $placeholders, modified_at = CURRENT_TIMESTAMP WHERE id = :id RETURNING *");
      $stmt->execute(array_merge($values, [':id' => $id]));

      $payload = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
    }

    return $payload;
  }

  public static function delete(int $id): array|false {
    $db = self::connect();

    $payload = false;

    try {
      $stmt = $db->prepare('DELETE FROM payloads WHERE id = :id RETURNING *');
      $stmt->execute([':id' => $id]);

      $payload = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
    }

    return $payload;
  }

  public static function all(): array {
    $db = self::connect();
    $all = [];

    try {
      $stmt = $db->query('SELECT * FROM payloads');
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
      $stmt = $db->query('SELECT COUNT(*) FROM payloads');
      $count = $stmt->fetchColumn();
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
    }

    return $count;
  }

  public static function truncate(): bool {
    $db = self::connect();

    try {
      $db->query('DELETE FROM payloads');
    } catch (\PDOException $e) {
      echo '<pre>' . print_r($e, true) . '</pre>';
      return false;
    }

    return true;
  }
}