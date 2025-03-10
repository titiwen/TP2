<?php 
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Helpers\Text;
use App\Model\Post;

$title = "Mon Blog";

define('PER_PAGE', 12);
define('POST_LIMIT', 100);

$pdo = new PDO('mysql:host=127.0.0.1;dbname=tutoblog', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$page = $_GET['page'] ?? 1;

if(!filter_var($page, FILTER_VALIDATE_INT)){
    throw new Exception('Numéro de page invalide');
}
if($page === '1'){
    header('Location: ' . $router->url('home'));
    http_response_code(301);
    exit();
}

$count = (int)$pdo->query('SELECT COUNT(id) FROM post')->fetch(PDO::FETCH_NUM)[0];
$pages = ceil($count / PER_PAGE);
$page = (int)($_GET['page'] ?? 1) ?: 1;
$perPage = PER_PAGE;
$page = $page > $pages ? $pages : $page;
$offset = $page > 1 ? $page * PER_PAGE - PER_PAGE : 0;
//dd($page, $pages,$offset);
$query = $pdo->query("SELECT * FROM post ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
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