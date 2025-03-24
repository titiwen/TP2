<?php
namespace App\Table;

use App\Model\Post;
use App\PaginatedQuery;
use Exception;

final class PostTable extends Table
{

    protected $table = "post";
    protected $entity = Post::class;

    public function delete(int $id){
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $ok = $query->execute([$id]);
        if($ok === false){
            throw new Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
        }

    }
    
    public function findPaginated()
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM post ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM post",
            $this->pdo
        );
        $posts = $paginatedQuery->getItems(Post::class);
        $postsByID = [];
        foreach ($posts as $post) {
            $postsByID[$post->getId()] = $post;
            $ids[] = $post->getId();
        }
        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

    public function findPaginatedForCategory(int $categoryID)
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT p.* 
            FROM post p
            JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id = {$categoryID}
            ORDER BY created_at DESC",
            "SELECT COUNT(category_id) 
            FROM post_category
            WHERE category_id = {$categoryID}",
            $this->pdo
        );
        $posts = $paginatedQuery->getItems(Post::class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        return [$posts, $paginatedQuery];
    }

    public function update(Post $post): void
    {
        $query = $this->pdo->prepare("UPDATE {$this->table} SET name = :name, slug = :slug, content = :content, created_at = :created_at WHERE id = :id");
        $ok = $query->execute([
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
            'id' => $post->getId()
        ]);
        if($ok === false){
            throw new Exception("Impossible de modifier l'enregistrement {$post->getId()} dans la table {$this->table}");
        }
    }

    public function add(Post $post): void
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} (name, slug, content, created_at) VALUES (:name, :slug, :content, :created_at)");
        $ok = $query->execute([
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        if ($ok === false) {
            throw new Exception("Impossible d'ajouter un nouvel enregistrement dans la table {$this->table}");
        }
        $post->setId((int)$this->pdo->lastInsertId());
    }
}