
<form action="" method="POST">
    <?= $form->input('name', 'Titre') ?>
    <?= $form->input('slug', 'URL') ?>
    
    <button href="<?= $router->url('admin_categories') ?>" class="ant-btn ant-btn-primary">
        <?php if($category->getID() !== null): ?>
            Modifier
        <?php else: ?>
            Créer
        <?php endif ?>
    </button>
</form>