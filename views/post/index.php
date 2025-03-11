<?php 
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Helpers\Text;
use App\Model\Post;
use App\Connection;
use App\URL;

$title = "Mon Blog";
$pdo = Connection::getPDO();

$page = $_GET['page'] ?? 1;
$count = (int)$pdo->query('SELECT COUNT(id) FROM post')->fetch(PDO::FETCH_NUM)[0];
$pages = ceil($count / PER_PAGE);
$page = URL::getPositiveInt('page', 1);
if($page > $pages){
    throw new Exception('Cette page n\'existe pas');
}
$offset = $page > 1 ? $page * PER_PAGE - PER_PAGE : 0;
$query = $pdo->query("SELECT * FROM post ORDER BY created_at DESC LIMIT " . PER_PAGE . " OFFSET $offset");
$posts = $query->fetchAll(PDO::FETCH_CLASS, Post::class);
?>

<h1>Mon Blog</h1>

<div class="container" >
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
        <?php if($page > 1): ?>
            <?php 
            $link = $router->url('home');
            if($page > 2) $link .= "?page=" . ($page - 1);
            ?>
            <a href="<?= $link ?>" class="ant-btn ant-btn-primary">&laquo; Page précédente</a>
        <?php endif ?>
    </div>
    <div>
        <?php if($page < $pages): ?>
            <a href="<?= $router->url('home') ?>?page=<?= $page + 1 ?>" class="ant-btn ant-btn-primary ant-btn-right">Page suivante &raquo;</a>
        <?php endif ?>
    </div>
</div>