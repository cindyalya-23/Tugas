<?php

abstract class Model
{
    protected PDO $db;
    protected string $table;
    protected string $pk;
    protected array $fields = [];

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function all(): array
    {
        return $this->db->query("SELECT * FROM {$this->table} ORDER BY {$this->pk} DESC")->fetchAll();
    }

    public function find(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->pk} = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function count(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
    }

    public function create(array $data): void
    {
        $cols = [];
        $params = [];
        foreach ($this->fields as $f) {
            $cols[] = "$f = :$f";
            $params[":$f"] = $data[$f] ?? null;
        }
        $this->db->prepare("INSERT INTO {$this->table} SET " . implode(', ', $cols))->execute($params);
    }

    public function update(int $id, array $data): void
    {
        $cols = [];
        $params = [':id' => $id];
        foreach ($this->fields as $f) {
            $cols[] = "$f = :$f";
            $params[":$f"] = $data[$f] ?? null;
        }
        $sql = "UPDATE {$this->table} SET " . implode(', ', $cols) . " WHERE {$this->pk} = :id";
        $this->db->prepare($sql)->execute($params);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->pk} = :id");
        $stmt->execute([':id' => $id]);
    }
}
