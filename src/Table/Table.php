<?php 
namespace App\Table;

use App\Table\Exception\NotFoundException;
use Exception;
use PDO;

abstract class Table{

    protected $pdo;
    protected $table = null;
    protected $entity = null;

    public function __construct(PDO $pdo)
    {
        if($this->table === null){
            throw new \Exception("La class " . get_class($this) . " n'a pas de propriété \$table");
        }
        if($this->entity === null){
            throw new \Exception("La class " . get_class($this) . " n'a pas de propriété \$entity");
        }
        $this->pdo = $pdo;
    }

    public function find(int $id)
    {
        $query = $this->pdo->prepare('
        SELECT * 
        FROM '.$this->table.'
        WHERE id = :id');
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->entity);
        $result = $query->fetch();
        if($result === false){
            throw new NotFoundException($this->table, $id);
        }
        return $result;
    }

    /**
     * Retourne si une valeur existe dans la table
     * @param string $field Champs à rechercher
     * @param mixed $value Valeur à associer au champ
     */
    public function exists(string $field, $value, ?int $except = null): bool
    {
        $sql = "SELECT COUNT(id) FROM {$this->table} WHERE $field = ?";
        $params = [$value];

        if($except !== null){
            $sql .=  " AND id != ?";
            $params[] = $except;
        }

        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0;
    }

    public function all(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->entity)->fetchAll();
    }
    

    public function delete(int $id){
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $ok = $query->execute([$id]);
        if($ok === false){
            throw new Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
        }
    }

    public function update(array $data, int $id): void
    {
        $sqlFields = [];
        foreach($data as $key => $value){
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("UPDATE {$this->table} SET ".implode(', ',$sqlFields)." WHERE id = :id");
        $ok = $query->execute(array_merge($data,['id' => $id]));
        if($ok === false){
            throw new Exception("Impossible de modifier l'enregistrement dans la table {$this->table}");
        }
    }

    public function add(array $data): int
    {
        $sqlFields = [];
        foreach($data as $key => $value){
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET ".implode(', ',$sqlFields));
        $ok = $query->execute($data);
        if($ok === false){
            throw new Exception("Impossible de modifier l'enregistrement dans la table {$this->table}");
        }
        return (int)$this->pdo->lastInsertId();
    }

    public function queryAndFetchAll(string $sql): array
    {
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->entity)->fetchAll();
    }
}