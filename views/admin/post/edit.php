<?php

use App\Connection;
use App\Table\PostTable;
use App\Validator;

$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$success = false;
$errors = [];

if(!empty($_POST)){
    Validator::lang('fr');
    $v = new Validator($_POST);
    $v->labels(array(
        'name' => 'Titre',
        'slug' => 'URL',
        'content' => 'Contenu'
    ));
    $v
    ->rule('required', ['name'])
    ->rule('lengthBetween', 'name', 3, 200);

    if($v->validate()){
        $postTable->update($post);
        $success = true;
    }else{
        $errors = $v->errors();
    }
    
}

?>

<?php if($success): ?>
    <div class="ant-alert ant-alert-success">
        L'article a bien été modifié
    </div>
<?php endif ?>

<?php if(!empty($errors)): ?>
    <div class="ant-alert ant-alert-error">
        L'article n'a pas pu être modifié, merci de corriger vos erreurs
    </div>
<?php endif ?>

<h1>Editer l'article n°<?= e($post->getID()) ?></h1>

<form action="" method="POST">
    <div class="ant-form-item">
        <label for="name">Titre</label>
        <input type="text" name="name" id="name" class="ant-input <?= isset($errors['name']) ? 'ant-input-status-error' : '' ?>" value="<?= e($post->getName()) ?>" required>
        <?php if(isset($errors['name'])): ?>
            <div class="ant-form-item-explain">
                <?= implode('<br>', $errors['name']) ?>
            </div>
        <?php endif ?>
    </div>
    <div class="ant-form-item">
        <label for="slug">URL</label>
        <input type="text" name="slug" id="slug" class="ant-input <?= isset($errors['slug']) ? 'ant-input-status-error' : '' ?>" value="<?= e($post->getSlug()) ?>" required>
        <?php if(isset($errors['slug'])): ?>
            <div class="ant-form-item-explain">
                <?= implode('<br>', $errors['slug']) ?>
            </div>
        <?php endif ?>
    </div>
    <div class="ant-form-item">
        <label for="content">Contenu</label>
        <textarea name="content" id="content" class="ant-input <?= isset($errors['content']) ? 'ant-input-status-error' : '' ?>" required><?= e($post->getContent()) ?></textarea>
        <?php if(isset($errors['content'])): ?>
            <div class="ant-form-item-explain">
                <?= implode('<br>', $errors['content']) ?>
            </div>
        <?php endif ?>
    </div>
    <button class="ant-btn ant-btn-primary">Modifier</button>
</form>