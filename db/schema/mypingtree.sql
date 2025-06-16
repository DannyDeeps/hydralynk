CREATE TABLE payloads (
  id          INTEGER PRIMARY KEY AUTOINCREMENT,
  name        TEXT NOT NULL,
  type        TEXT NOT NULL,
  created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
  modified_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  CHECK (type IN ('json', 'xml', 'plaintext'))
);

CREATE TABLE payload_nodes (
  id          INTEGER PRIMARY KEY AUTOINCREMENT,
  payload_id  INTEGER NOT NULL,
  name        TEXT NOT NULL,
  value       TEXT NOT NULL,
  type        TEXT NOT NULL,
  parent_id   INTEGER,
  created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
  modified_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  CHECK (type IN ('string', 'integer', 'float'))
  FOREIGN KEY (payload_id) REFERENCES payloads(id),
  FOREIGN KEY (parent_id) REFERENCES payload_nodes(id)
);