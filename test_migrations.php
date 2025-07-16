<?php
echo "Test de fonctionnement...\n";
if (!file_exists(__DIR__.'/vendor/autoload.php')) {
    die("Exécutez 'composer install' d'abord\n");
}
require __DIR__.'/vendor/autoload.php';
echo "Autoload chargé avec succès!\n";
