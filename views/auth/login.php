<?php

use App\Connection;
use App\Model\User;
use App\HTML\Form;
use App\Table\Exception\NotFoundException;
use App\Table\UserTable;

$user = new User();
$form = new Form($user, []);
$errors = [];
if(!empty($_POST)){
    $user->setUsername($_POST['username']);
    if(empty($_POST['username']) || empty($_POST['password'])){
        $form->setError('Identifiant ou mot de passe incorrect','password');
    }
    $table = new UserTable(Connection::getPDO());
    try{
        $u = $table->findByUsername($_POST['username']);
        if(password_verify($_POST['password'], $u->getPassword())){
            session_start();
            $_SESSION['auth'] = $u->getID();
            header('Location: ' . $router->url('admin_posts'));
            exit();
        }else{
            $form->setError('Identifiant ou mot de passe incorrect','password');
        }
    }catch(NotFoundException $e){
        $form->setError('Identifiant ou mot de passe incorrect','password');
    }
}

?>

<h1>Se connecter</h1>

<?php if(isset($_GET['forbidden'])): ?>
    <div class="ant-alert ant-alert-error ant-alert-danger">
        Vous ne pouvez pas accéder à cette page sans être identifié
    </div>
<?php endif ?>


<form action="<?= $router->url('login') ?>" method="POST">
    <?= $form->input('username', 'Pseudo') ?>
    <?= $form->input('password', 'Mot de passe') ?>
    <button type="submit" class="ant-btn ant-btn-primary">
        Se connecter
    </button>
</form>
