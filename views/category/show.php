<?php

use App\Connection;
use App\Model\Category;
use App\Model\Post;
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

$page = $_GET['page'] ?? 1;

$count = (int)$pdo->query('
SELECT COUNT(category_id) 
FROM post_category
WHERE category_id = ' . 
$category->getID())
->fetch(PDO::FETCH_NUM)[0];

$pages = ceil($count / PER_PAGE);
$page = URL::getPositiveInt('page', 1);
if($page > $pages){
    throw new Exception('Cette page n\'existe pas');
}
$offset = $page > 1 ? $page * PER_PAGE - PER_PAGE : 0;
$query = $pdo->query("
SELECT p.* 
FROM post p
JOIN post_category pc ON pc.post_id = p.id
WHERE pc.category_id = " . $category->getID() . "
ORDER BY created_at 
DESC LIMIT " . PER_PAGE . " OFFSET $offset");
$posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);
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
        <?php if($page > 1): ?>
            <?php 
            $l = $link;
            if($page > 2) $l .= "?page=" . ($page - 1);
            ?>
            <a href="<?= $link ?>" class="ant-btn ant-btn-primary">&laquo; Page précédente</a>
        <?php endif ?>
    </div>
    <div>
        <?php if($page < $pages): ?>
            <a href="<?= $link ?>?page=<?= $page + 1 ?>" class="ant-btn ant-btn-primary ant-btn-right">Page suivante &raquo;</a>
        <?php endif ?>
    </div>
</div>