<?php

use App\Auth;
use App\Connection;
use App\Table\CategoryTable;

Auth::check();

$pdo = Connection::getPDO();
$table = new CategoryTable($pdo);
$table->delete($params['id']);
header('Location: ' . $router->url('admin_categories') . '?delete='.$params['id']);
exit();

?>

<h1>Supression de la catégorie n°<?= $params['id'] ?></h1>