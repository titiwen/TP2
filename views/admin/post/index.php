<?php

use App\Auth;
use App\Connection;

Auth::check();

$router->layout = 'admin/layouts/default';
$title = "Admin";
$pdo = Connection::getPDO();
[$posts, $pagination] = (new \App\Table\PostTable($pdo))->findPaginated();
$link = $router->url('admin_posts');
?>

<?php if(isset($_GET['delete'])): ?>
    <div class="ant-alert ant-alert-success">
        L'article n°<?= $_GET['delete'] ?> a bien été supprimé
    </div>
<?php endif ?>
 
<div style="display: flex; justify-content: center;">
    <table class="ant-table" style=" width: 70%;">
        <thead class="ant-table-thead">
            <tr>
                <th class="ant-table-cell">#ID</th>
                <th class="ant-table-cell">Titre</th>
                <th class="ant-table-cell">
                    <a href="<?= $router->url('admin_post_new') ?>">
                        Créer un article
                    </a>
                </th>
            </tr>
        </thead>
        <tbody class="ant-table-tbody">
            <?php foreach($posts as $post): ?>
                <tr class="ant-table-row">
                    <td class="ant-table-cell">
                        #<?= e($post->getID()) ?>
                    </td>
                    <td class="ant-table-cell">
                        <a href="<?= $router->url('admin_post', ['id' => $post->getID()]) ?>">
                            <?= e($post->getName()) ?>
                        </a>
                    </td>
                    <td class="ant-table-cell">
                        <a href="<?= $router->url('admin_post', ['id' => $post->getID()]) ?>" class="ant-btn ant-btn-primary">
                            Editer
                        </a>
                        <form action="<?= $router->url('admin_post_delete', ['id' => $post->getID()]) ?>"method="POST"
                        onsubmit="return confirm('Voulez-vous vraiment supprimer cet article ?')" style="display:inline;">
                            <button type="submit" class="ant-btn ant-btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<div class="pagination-container" style="margin-top: 20px;">
    <div class="ant-row ant-row-space-between my-4">
        <div>
            <?= $pagination->previousLink($link) ?>
        </div>
        <div>
            <?= $pagination->nextLink($link) ?>
        </div>
    </div>
</div>