<?php

use App\Connection;
use App\Table\PostTable;
use App\Validator;
use App\HTML\Form;
use App\Model\Post;
use App\Validators\PostValidator;

$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$post = $postTable->find($params['id']);
$success = false;
$errors = [];

if(!empty($_POST)){
    Validator::lang('fr');
    $v = new PostValidator($_POST, $postTable, $post->getID());

    if($v->validate()){
        $post->setName($_POST['name']);
        $post->setSlug($_POST['slug']);
        $post->setContent($_POST['content']);
        $post->setCreatedAt($_POST['created_at']);   
        $postTable->update($post);
        $success = true;
    }else{
        $errors = $v->errors();
    }
    
}

$form = new Form($post, $errors);

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

<h1>Editer l'article n°<?= htmlspecialchars($post->getID(), ENT_QUOTES, 'UTF-8') ?></h1>


<form action="" method="POST">

    <?= $form->input('name', 'Titre') ?>
    <?= $form->input('slug', 'URL') ?>
    <?= $form->textarea('content', 'Contenu') ?>
    <?= $form->input('created_at', 'Date de création') ?>
    
    <button class="ant-btn ant-btn-primary">Modifier</button>
</form>