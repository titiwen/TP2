<!DOCTYPE html>
<html lang="fr" class="ant-layout">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Mon site' ?></title>
    <!-- Inclusion des fichiers CSS d'Ant Design -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/antd/4.16.13/antd.min.css" />
</head>
<body class="ant-layout">
    <header>
        <div class="ant-layout-header">
            <div class="logo" style="float: left; width: 120px; height: 31px; margin: 16px 24px 16px 0; background: rgba(255, 255, 255, 0.2);"></div>
            <div class="ant-menu ant-menu-dark ant-menu-horizontal" style="line-height: 64px;">
                <a href="/blog" class="ant-menu-item">Blog</a>
                <a href="/blog/category" class="ant-menu-item">Catégorie</a>
            </div>
        </div>
    </header>
    <!-- Inclusion des fichiers JS d'Ant Design -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/antd/4.16.13/antd.min.js"></script>
    <div class="ant-layout-content" style="padding: 24px; background: #fff;">
        <?= $content ?>
    </div>
    <footer>
    <div class="ant-layout-footer" style="text-align: center;">
        <?php if(defined('DEBUG_TIME')): ?>
            Page générée en <?= round(1000*(microtime(true) - DEBUG_TIME))?> ms
            <?php endif ?>
    </div>
    <!-- Inclusion des fichiers JS d'Ant Design -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/antd/4.16.13/antd.min.js"></script>
    </footer>
</body>
</html>