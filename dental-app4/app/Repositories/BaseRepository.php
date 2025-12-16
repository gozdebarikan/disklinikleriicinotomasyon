<?php


namespace App\Repositories;

use PDO;

abstract class BaseRepository {
    protected $db;
    protected $table;
    
    public function __construct(PDO $db) {
        $this->db = $db;
    }
    
    
    public function findById($id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    
    public function findAll(int $limit = 100, int $offset = 0): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} LIMIT ? OFFSET ?");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll();
    }
    
    
    public function findBy(string $column, $value): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = ?");
        $stmt->execute([$value]);
        return $stmt->fetchAll();
    }
    
    
    public function findOneBy(string $column, $value): ?array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = ? LIMIT 1");
        $stmt->execute([$value]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    
    public function create(array $data): int|string {
        $columns = array_keys($data);
        $placeholders = array_fill(0, count($columns), '?');
        
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $this->table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));
        
        return $this->db->lastInsertId();
    }
    
    
    public function update($id, array $data): bool {
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            $fields[] = "{$key} = ?";
            $values[] = $value;
        }
        
        $values[] = $id;
        
        $sql = sprintf(
            "UPDATE %s SET %s WHERE id = ?",
            $this->table,
            implode(', ', $fields)
        );
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }
    
    
    public function delete($id): bool {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    
    public function exists(string $column, $value): bool {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM {$this->table} WHERE {$column} = ?");
        $stmt->execute([$value]);
        return $stmt->fetchColumn() > 0;
    }
    
    
    public function count(array $where = []): int {
        if (empty($where)) {
            $stmt = $this->db->query("SELECT COUNT(*) FROM {$this->table}");
            return $stmt->fetchColumn();
        }
        
        $conditions = [];
        $values = [];
        
        foreach ($where as $key => $value) {
            $conditions[] = "{$key} = ?";
            $values[] = $value;
        }
        
        $sql = sprintf(
            "SELECT COUNT(*) FROM %s WHERE %s",
            $this->table,
            implode(' AND ', $conditions)
        );
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchColumn();
    }
}
