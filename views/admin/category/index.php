<?php

use App\Auth;
use App\Connection;
use App\Table\CategoryTable;

Auth::check();

$router->layout = 'admin/layouts/default';
$title = "Gestion des catégories";
$pdo = Connection::getPDO();
$link = $router->url('admin_categories');
$categories = (new CategoryTable($pdo))->all();
?>

<?php if(isset($_GET['delete'])): ?>
    <div class="ant-alert ant-alert-success" style="margin: 10px">
        La catégorie n°<?= $_GET['delete'] ?> a bien été supprimée
    </div>
<?php endif ?>
 
<div style="display: flex; justify-content: center;">
    
    <table class="ant-table" style=" width: 70%;">
        <thead class="ant-table-thead">
            <tr>
                <th class="ant-table-cell">#ID</th>
                <th class="ant-table-cell">Titre</th>
                <th class="ant-table-cell"><a href="<?= $router->url('admin_category_new') ?>" class="ant-btn ant-btn-primary">Créer nouveau</a></th>
            </tr>
        </thead>
        <tbody class="ant-table-tbody">
            <?php foreach($categories as $category): ?>
                <tr class="ant-table-row">
                    <td class="ant-table-cell">
                        #<?= e($category->getID()) ?>
                    </td>
                    <td class="ant-table-cell">
                        <a href="<?= $router->url('admin_category', ['id' => $category->getID()]) ?>">
                            <?= e($category->getName()) ?>
                        </a>
                    </td>
                    <td class="ant-table-cell">
                        <a href="<?= $router->url('admin_category', ['id' => $category->getID()]) ?>" class="ant-btn ant-btn-primary">
                            Editer
                        </a>
                        <form action="<?= $router->url('admin_category_delete', ['id' => $category->getID()]) ?>"method="POST"
                        onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?')" style="display:inline;">
                            <button type="submit" class="ant-btn ant-btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>