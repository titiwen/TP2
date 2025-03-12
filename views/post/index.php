<?php 
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Helpers\Text;
use App\Model\Post;
use App\Connection;
use App\Model\Category;
use App\PaginatedQuery;
use App\URL;

$title = "Mon Blog";

$pdo = Connection::getPDO();

$paginatedQuery = new PaginatedQuery(
    "SELECT * FROM post ORDER BY created_at DESC",
    "SELECT COUNT(id) FROM post"
);

$posts = $paginatedQuery->getItems(Post::class);
$postsByID = [];
foreach ($posts as $post) {
    $postsByID[$post->getId()] = $post;
    $ids[] = $post->getId();
}
$categories = $pdo
    ->query("
        SELECT c.*, pc.post_id 
        FROM post_category pc 
        JOIN category c ON pc.category_id = c.id
        WHERE pc.post_id IN (" . implode(',', array_keys($postsByID)) . ")")
    ->fetchAll(PDO::FETCH_CLASS, Category::class);
foreach ($categories as $category) {
    if (!isset($postsByID[$category->getPostId()])) {
        continue;
    }
    $postsByID[$category->getPostId()]->addCategory($category);
}



$link = $router->url('home');
?>

<h1>Mon Blog</h1>

<div class="container">
    <div class="ant-row-gutter" style="display: flex; flex-wrap: wrap; clear: both;">
        <?php foreach ($posts as $post): ?>
            <div class="ant-col ant-col-md-6 ant-col-lg-4">
                <?php require 'card.php' ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="ant-row ant-row-space-between my-4">
    <div>
        <?= $paginatedQuery->previousLink($link) ?>
    </div>
    <div>
        <?= $paginatedQuery->nextLink($link) ?>
    </div>
</div>
