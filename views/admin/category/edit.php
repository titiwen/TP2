<?php

use App\Auth;
use App\Connection;
use App\CustomObject;
use App\Table\CategoryTable;
use App\HTML\Form;
use App\Validators\CategoryValidator;

Auth::check();

$pdo = Connection::getPDO();
$table = new CategoryTable($pdo);
$category = $table->find($params['id']);
$success = false;
$errors = [];
$fields = ['name', 'slug'];

if (!empty($_POST)) {
    $v = new CategoryValidator($_POST, $table, $category->getID());

    if ($v->validate()) {
        CustomObject::hydrate($category, $_POST, $fields);
        $table->update([
            'name' => $category->getName(),
            'slug' => $category->getSlug()
        ], $category->getID());
        $success = true;
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($category, $errors);

?>

<?php if ($success): ?>
    <div class="ant-alert ant-alert-success">
        La catégorie a bien été modifié.
    </div>
<?php endif ?>

<?php if (!empty($errors)): ?>
    <div class="ant-alert ant-alert-error">
        La catégorie n'a pas pu être modifié, merci de corriger vos erreurs.
    </div>
<?php endif ?>

<h1>Editer la catégorie n°<?= htmlspecialchars($category->getID(), ENT_QUOTES, 'UTF-8') ?></h1>

<?php require '_form.php' ?>