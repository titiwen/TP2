<?php

use App\Connection;
use App\Model\{ Category};
use App\Table\CategoryTable;
use App\Table\PostTable;

$id = (int)$params['id'];
$slug = $params['slug'];

$pdo = Connection::getPDO();

$post = (new PostTable($pdo))->find($id);
(new CategoryTable($pdo))->hydratePosts([$post]);

if($post->getSlug() !== $slug)
{
    $url = $router->url('post', ['slug' => $post->getSlug(), 'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);
}
?>

<h2 class="ant-card-title"><?= e($post->getName()) ?></h2>
<span class="ant-typography ant-typography-secondary">
    <?php 
        echo $post->getCreatedAt()->format('d F Y');
    ?>
</span>
<?php foreach($post->getCategories() as $k => $category): ?>
    <a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]) ?>" class="ant-tag ant-tag-has-color ant-tag-blue"><?= e($category->getName()) ?></a>
<?php endforeach; ?>
<p>
    <?php 
        echo $post->getFormattedContent();
    ?>
</p>