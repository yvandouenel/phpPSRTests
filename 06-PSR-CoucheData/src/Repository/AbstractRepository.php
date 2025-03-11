<?php

namespace Diginamic\Framework\Repository;

use Diginamic\Framework\Database\Database;
use PDO;

abstract class AbstractRepository implements RepositoryInterface
{
  protected PDO $db;
  protected string $table;
  protected string $entityClass;

  public function __construct()
  {
    $this->db = Database::getInstance();
  }

  public function findAll(): array
  {
    $stmt = $this->db->query("SELECT * FROM {$this->table}");
    return $stmt->fetchAll(PDO::FETCH_CLASS, $this->entityClass);
  }

  public function findById(int $id): ?object
  {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $id]);
    $stmt->setFetchMode(PDO::FETCH_CLASS, $this->entityClass);

    $entity = $stmt->fetch();
    return $entity ?: null;
  }

  abstract public function save(object $entity): bool;

  public function delete(int $id): bool
  {
    $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
    return $stmt->execute(['id' => $id]);
  }
}
