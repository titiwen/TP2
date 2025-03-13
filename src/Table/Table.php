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
}