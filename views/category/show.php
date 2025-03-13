<?php

use App\Connection;
use App\Model\Category;
use App\Model\Post;
use App\PaginatedQuery;
use App\Table\CategoryTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();
$categoryTable = new CategoryTable($pdo);
$category = (new CategoryTable($pdo))->find($id);


if($category->getSlug() !== $slug)
{
    $url = $router->url('category', ['slug' => $category->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}

$title = "Catégorie : {$category->getName()}";
[$posts, $paginatedQuery] = (new \App\Table\PostTable($pdo))->findPaginatedForCategory($category->getID());

$link = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
?>

<h1><?= e($title) ?></h1>

<div class="container" >
    <div class="ant-row-gutter" style="display: flex; flex-wrap: wrap; clear: both;">
        <?php foreach ($posts as $post): ?>
            <div class="ant-col ant-col-md-6 ant-col-lg-4" style = "margin: 10px; ">
                <?php require dirname(__DIR__).'/post/card.php' ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="ant-row ant-row-space-between my-4" style="margin-top: 24px; ">
    <div>
        <?= $paginatedQuery->previousLink($link) ?>
    </div>
    <div>
        <?= $paginatedQuery->nextLink($link) ?>
    </div>
</div>