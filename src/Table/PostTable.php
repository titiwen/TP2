<?php
namespace App\Table;

use App\Model\Post;
use App\PaginatedQuery;

final class PostTable extends Table
{

    protected $table = "post";
    protected $entity = Post::class;

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
}