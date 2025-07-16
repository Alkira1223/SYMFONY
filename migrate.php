<?php
require __DIR__.'/vendor/autoload.php';

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Dotenv\Dotenv;

// Charge les variables d'environnement
(new Dotenv())->bootEnv(__DIR__.'/.env');

try {
    // Vérification/Création de la base SQLite
    $dbFile = __DIR__.'/var/data.db';
    if (!file_exists($dbFile)) {
        file_put_contents($dbFile, '');
    }

    // Initialisation
    $kernel = new Kernel($_SERVER['APP_ENV'], (bool)$_SERVER['APP_DEBUG']);
    $application = new Application($kernel);
    $application->setAutoExit(false);

    // Exécution des migrations
    $exitCode = $application->run(
        new ArrayInput([
            'command' => 'doctrine:migrations:migrate',
            '--no-interaction' => true,
            '--allow-no-migration' => true
        ]),
        new \Symfony\Component\Console\Output\ConsoleOutput()
    );

    exit($exitCode);

} catch (Throwable $e) {
    echo "ERREUR: ".$e->getMessage()."\n";
    exit(1);
}
