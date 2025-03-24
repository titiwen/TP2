<?php

use App\Auth;
use App\Connection;
use App\CustomObject;
use App\HTML\Form;
use App\Model\Post;
use App\Table\PostTable;
use App\Validators\PostValidator;

Auth::check();

$pdo = Connection::getPDO();
$table = new PostTable($pdo);
$post = new Post();
$success = false;
$errors = [];

if (!empty($_POST)) {
    $v = new PostValidator($_POST, $table);
    if ($v->validate()) {
        CustomObject::hydrate($post, $_POST, ['name', 'slug', 'content', 'created_at']);
        $table->addPost($post);
        $success = true;

        // Réinitialiser l'objet $post pour vider le formulaire
        $post = new Post();
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($post, $errors);

?>

<?php if ($success): ?>
    <div class="ant-alert ant-alert-success">
        L'article a bien été créé.
    </div>
<?php endif ?>

<?php if (!empty($errors)): ?>
    <div class="ant-alert ant-alert-error">
        L'article n'a pas pu être créé, merci de corriger vos erreurs.
    </div>
<?php endif ?>

<h1>Créer un nouvel article</h1>

<?php require '_form.php' ?>
