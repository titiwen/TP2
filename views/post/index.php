<?php 
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Connection;
use App\Table\PostTable;

$title = "Mon Blog";

$pdo = Connection::getPDO();

$table = new PostTable($pdo);
[$posts, $pagination] = $table->findPaginated();

$link = $router->url('home');
?>

<h1>Mon Blog</h1>

<div class="container">
    <div class="ant-row-gutter" style="display: flex; flex-wrap: wrap; clear: both;">
        <?php foreach ($posts as $post): ?>
            <div class="ant-col ant-col-md-6 ant-col-lg-4"style="margin: 10px; ">
                <?php require 'card.php' ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="pagination-container" style="margin-top: 20px;">
        <div class="ant-row ant-row-space-between my-4">
            <div>
                <?= $pagination->previousLink($link) ?>
            </div>
            <div>
                <?= $pagination->nextLink($link) ?>
            </div>
        </div>
    </div>
</div>

