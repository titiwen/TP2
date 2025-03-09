<?php 
require "../vendor/autoload.php";

define('DEBUG_TIME', microtime(true));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$router = new App\Router(dirname(__DIR__).'/views');
$router
    ->get('/', 'post/index', 'home')
    ->get('blog/[*:slug]-[i:id]', 'post/show', 'post')
    ->get('/category', 'category/show', 'category')
    ->run();