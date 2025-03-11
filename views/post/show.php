<?php

use App\Connection;
use App\Model\{Post, Category};

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();

$query = $pdo->prepare('SELECT * FROM post WHERE id = :id');
$query->execute(['id' => $id]);
$query->setFetchMode(PDO::FETCH_CLASS, Post::class);
/** @var Post|false */
$post = $query->fetch();

if($post === false){
    throw new Exception('Aucun article ne correspond à cet ID');
}

if($post->getSlug() !== $slug)
{
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}

$query = $pdo->prepare('
SELECT c.id, c.slug, c.name 
FROM post_category pc 
JOIN category c ON c.id = pc.category_id
WHERE pc.post_id = :id');
$query->execute(['id' => $post->getID()]);
$query->setFetchMode(PDO::FETCH_CLASS, Category::class);
/** @var Category[] */
$categories = $query->fetchAll();
?>

<h2 class="ant-card-title"><?= e($post->getName()) ?></h2>
<span class="ant-typography ant-typography-secondary">
    <?php 
        echo $post->getCreatedAt()->format('d F Y');
    ?>
</span>
<?php foreach($categories as $k => $category): ?>
    <a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]) ?>" class="ant-tag ant-tag-has-color ant-tag-blue"><?= e($category->getName()) ?></a>
<?php endforeach; ?>
<p>
    <?php 
        echo $post->getFormattedContent();
    ?>
</p>