<div class="ant-card-bordered" style="flex: 1;">
    <div class="ant-card-body">
        <h2 class="ant-card-title"><?= $post->getName() ?></h2>
        <span class="ant-typography ant-typography-secondary">
            <?php 
            echo $post->getCreatedAt()->format('d F Y');
            ?>
        </span>
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