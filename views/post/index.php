<?php 
require_once __DIR__ . '/../../vendor/autoload.php';
use App\Helpers\Text;
$title = "Mon Blog";

$pdo = new PDO('mysql:host=127.0.0.1;dbname=tutoblog', 'root', 'root', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
$query = $pdo->query("SELECT * FROM post ORDER BY created_at DESC LIMIT 12");
$posts = $query->fetchAll(PDO::FETCH_OBJ);

?>

<h1>Mon Blog</h1>

<div class="row" style="display: flex; flex-wrap: wrap;">
    <?php foreach ($posts as $post): ?>
        <div class="ant-col ant-col-md-6 ant-col-lg-4" style="display: flex; flex-direction: column; margin-bottom: 20px; flex: 1 0 30%;">
            <div class="ant-card" style="flex: 1;">
                <div class="ant-card-body">
                    <h2 class="ant-card-title"><?= htmlspecialchars($post->name) ?></h2>
                    <p>
                        <?php 
                        $content = htmlspecialchars($post->content);
                        echo Text::excerpt($content); 
                        ?>
                    </p>
                    <?php if(strlen($content) > 100): ?>
                        <p><a href="post.php?id=<?= $post->id ?>">Lire la suite</a></p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>