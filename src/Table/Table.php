<?php 
namespace App\Table;

use App\Table\Exception\NotFoundException;
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
}