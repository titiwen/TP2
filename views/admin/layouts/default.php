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
                <a href="/" class="ant-menu-item" style="display: inline-block;">Blog</a>
                <div class="ant-menu-submenu" style="display: inline-block; position: relative; z-index: 1000;">
                    <span class="ant-menu-submenu-title" style="cursor: pointer;">Admin</span>
                    <ul class="ant-menu ant-menu-sub" style="position: absolute; top: 100%; left: 0; display: none; background: #001529; padding: 0; list-style: none; z-index: 1000;">
                        <li class="ant-menu-item" style="padding: 10px; margin: 10px;">
                            <a href="<?= $router->url('admin_posts') ?>" style="color: #fff; text-decoration: none;">Articles</a>
                        </li>
                        <li class="ant-menu-item" style="padding: 10px; margin: 10px;">
                            <a href="<?= $router->url('admin_categories') ?>" style="color: #fff; text-decoration: none;">Catégories</a>
                        </li>
                    </ul>
                </div>
                <script>
                    document.querySelector('.ant-menu-submenu-title').addEventListener('mouseover', function() {
                        document.querySelector('.ant-menu-sub').style.display = 'block';
                    });
                    document.querySelector('.ant-menu-submenu').addEventListener('mouseleave', function() {
                        document.querySelector('.ant-menu-sub').style.display = 'none';
                    });
                </script>
                <script>
                    document.querySelector('.ant-menu-submenu-title').addEventListener('mouseover', function() {
                        document.querySelector('.ant-menu-sub').style.display = 'block';
                    });
                    document.querySelector('.ant-menu-submenu').addEventListener('mouseleave', function() {
                        document.querySelector('.ant-menu-sub').style.display = 'none';
                    });
                </script>
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