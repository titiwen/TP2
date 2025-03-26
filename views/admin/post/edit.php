<?php

use App\Auth;
use App\Connection;
use App\CustomObject;
use App\Table\PostTable;
use App\HTML\Form;
use App\Table\CategoryTable;
use App\Validators\PostValidator;

Auth::check();

$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
$post = $postTable->find($params['id']);
$categoryTable->hydratePosts([$post]);
$success = false;
$errors = [];

if(!empty($_POST)){
    $v = new PostValidator($_POST, $postTable, $post->getID(), $categories);
    CustomObject::hydrate($post, $_POST, ['name', 'slug', 'content', 'created_at']);
    if($v->validate()){
        $pdo->beginTransaction();  
        $postTable->updatePost($post);
        $postTable->attachCategories($post->getID(), $_POST['categories_ids']);
        $pdo->commit();
        $categoryTable->hydratePosts([$post]);
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

<?php require '_form.php' ?>