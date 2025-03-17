<?php
$categories = [];
foreach($post->getCategories() as $k => $category){
    $url = $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]);
    $categories[] = <<<HTML
    <a href="{$url}" class="ant-tag ant-tag-has-color ant-tag-blue">{$category->getName()}</a>
HTML;   
}

?>

<div class="ant-card-bordered" style="flex: 1;">
    <div class="ant-card-body">
        <h2 class="ant-card-title"><?= $post->getName() ?></h2>
            <?php 
            echo $post->getCreatedAt()->format('d F Y');?>
                <?php if(!empty($post->getCategories())): ?>
                    ::
                    <?= implode('', $categories) ?>
                <?php endif ?>
        <p>
            <?php 
                echo $post->getExcerpt();
            ?>
        </p>
        <?php if(strlen($post->getExcerpt()) > POST_LIMIT): ?>
            <p><a href="<?= $router->url('post',['id'=>$post->getId(), 'slug' => $post->getSlug()])?>">Lire la suite</a></p>
        <?php endif ?>
    </div>
</div>