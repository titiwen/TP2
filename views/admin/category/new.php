<?php

use App\Auth;
use App\Connection;
use App\CustomObject;
use App\HTML\Form;
use App\Model\Category;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;

Auth::check();

$category = new Category();
$success = false;
$errors = [];

if (!empty($_POST)) {
    $pdo = Connection::getPDO();
    $table = new CategoryTable($pdo);

    $v = new CategoryValidator($_POST, $table);
    CustomObject::hydrate($category, $_POST, ['name', 'slug']);
    if ($v->validate()) {
        $table->add($category);
        $success = true;
        header('Location: ' . $router->url('admin_categories') . '?created=1');
        exit();
    } else {
        $errors = $v->errors();
    }
}

$form = new Form($category, $errors);

?>

<?php if ($success): ?>
    <div class="ant-alert ant-alert-success">
        La catégorie a bien été créé.
    </div>
<?php endif ?>

<?php if (!empty($errors)): ?>
    <div class="ant-alert ant-alert-error">
        La catégorie n'a pas pu être créé, merci de corriger vos erreurs.
    </div>
<?php endif ?>

<h1>Créer une nouvelle catégorie</h1>

<?php require '_form.php' ?>
