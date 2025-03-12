<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : 'Mon site' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/antd/4.16.13/antd.min.css" />
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .flex-content {
            flex: 1;
            padding: 24px;
            background: #fff;
        }
        .flex-footer {
            text-align: center;
            background: #f1f1f1;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="flex-header">
            <div class="logo" style="float: left; width: 120px; height: 31px; margin: 16px 24px 16px 0; background: rgba(255, 255, 255, 0.2);"></div>
            <div class="ant-menu ant-menu-dark ant-menu-horizontal" style="line-height: 64px;">
                <a href="/" class="ant-menu-item">Blog</a>
                <!-- <a href="/category" class="ant-menu-item">Catégorie</a> -->
            </div>
        </div>
    </header>
    <div class="flex-content">
        <?= $content ?>
    </div>
    <footer class="flex-footer">
        <?php if(defined('DEBUG_TIME')): ?>
            Page générée en <?= round(1000*(microtime(true) - DEBUG_TIME))?> ms
        <?php endif ?>
    </footer>
    <!-- Inclusion des fichiers JS d'Ant Design -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/antd/4.16.13/antd.min.js"></script>
</body>
</html>