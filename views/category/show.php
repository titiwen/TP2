<?php

use App\Connection;
use App\Model\Category;
use App\Model\Post;
use App\PaginatedQuery;
use App\URL;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();

$query = $pdo->prepare('
SELECT * 
FROM category 
WHERE id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
/** @var Category|false */
$category = $query->fetch();

if($category === false){
    throw new Exception('Aucune catégorie ne correspond à cet ID');
}

if($category->getSlug() !== $slug)
{
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}

$title = "Catégorie : {$category->getName()}";

/**
 * Paramètres qui varient : 
 * $sqlListing: string
 * $classMapping: string
 * $sqlCount: string
 * $pdo: PDO = Connection::getPDO()
 * PER_PAGE: int = 12
 * 
 * Methodes :
 * getItems(): array
 * previousPageLink(): ?string
 * nextPageLink(): ?string
 */

 $paginatedQuery = new PaginatedQuery("
 SELECT p.* 
 FROM post p
 JOIN post_category pc ON pc.post_id = p.id
 WHERE pc.category_id = " . $category->getID() . "
 ORDER BY created_at DESC", 

"SELECT COUNT(category_id) 
FROM post_category
WHERE category_id = {$category->getID()}");

/** @var Post[] */
$posts = $paginatedQuery->getItems(Post::class);
$link = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
?>

<h1><?= e($title) ?></h1>

<div class="container" >
    <div class="ant-row-gutter" style="display: flex; flex-wrap: wrap; clear: both;">
        <?php foreach ($posts as $post): ?>
            <div class="ant-col ant-col-md-6 ant-col-lg-4">
                <?php require dirname(__DIR__).'/post/card.php' ?>
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