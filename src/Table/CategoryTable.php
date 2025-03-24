<?php 
namespace App\Table;

use App\Model\Category;
use Exception;
use PDO;

final class CategoryTable extends Table
{
    protected $table = "category"; 
    protected $entity = Category::class;

    /**
     * @param APP\MODEL\Posts[] $posts
     */
    public function hydratePosts(array $posts): void
    {
        $postsByID = [];
        foreach ($posts as $post) {
            $postsByID[$post->getId()] = $post;
            $ids[] = $post->getId();
        }
        $categories = $this->pdo
            ->query("
                SELECT c.*, pc.post_id 
                FROM post_category pc 
                JOIN category c ON pc.category_id = c.id
                WHERE pc.post_id IN (" . implode(',', array_keys($postsByID)) . ")")
            ->fetchAll(PDO::FETCH_CLASS, $this->entity);
        foreach ($categories as $category) {
            if (!isset($postsByID[$category->getPostId()])) {
                continue;
            }
            $postsByID[$category->getPostId()]->addCategory($category);
        }
    }

    public function add(Category $category): void
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} (name, slug) VALUES (:name, :slug)");
        $ok = $query->execute([
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
        ]);
        if ($ok === false) {
            throw new Exception("Impossible d'ajouter un nouvel enregistrement dans la table {$this->table}");
        }
        $category->setId((int)$this->pdo->lastInsertId());
    }

    public function update(Category $category): void
    {
        $query = $this->pdo->prepare("UPDATE {$this->table} SET name = :name, slug = :slug WHERE id = :id");
        $ok = $query->execute([
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
            'id' => $category->getId()
        ]);
        if($ok === false){
            throw new Exception("Impossible de modifier l'enregistrement {$category->getId()} dans la table {$this->table}");
        }
    }

    public function delete(int $id){
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $ok = $query->execute([$id]);
        if($ok === false){
            throw new Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
        }

    }
}
?>