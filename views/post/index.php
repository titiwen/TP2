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
$query = $pdo->query("SELECT * FROM post ORDER BY created_at DESC LIMIT 12");
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