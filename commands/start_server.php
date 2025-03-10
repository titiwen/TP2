<?php

// Commande pour démarrer le serveur PHP intégré
$command = 'php -S localhost:8000 -t public';

// Exécute la commande
echo "Démarrage du serveur PHP intégré...\n";
passthru($command);