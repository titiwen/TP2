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
            $post->setCategories([]);
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

    public function all(): array
    {
        return $this->queryAndFetchAll("SELECT * FROM {$this->table} ORDER BY id ASC");
    }

    public function list(): array
    {
        $categories = $this->queryAndFetchAll("SELECT * FROM {$this->table} ORDER BY name ASC");
        $results = [];
        foreach ($categories as $category) {
            $results[$category->getId()] = $category->getName();
        }
        return $results;
    }
}
?>