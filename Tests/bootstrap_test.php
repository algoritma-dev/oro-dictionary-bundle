<?php

declare(strict_types=1);

use Oro\Bundle\EntityExtendBundle\Test\EntityExtendTestInitializer;
use Symfony\Component\Dotenv\Dotenv;

$autoloadPaths = [
    \dirname(__DIR__) . '/../../../../vendor/autoload.php',
    \dirname(__DIR__) . '/../../../vendor/autoload.php',
    \dirname(__DIR__) . '/../../vendor/autoload.php',
    \dirname(__DIR__) . '/../vendor/autoload.php',
    \dirname(__DIR__) . '/vendor/autoload.php',
];

$loader = null;
foreach ($autoloadPaths as $path) {
    if (file_exists($path)) {
        $loader = require $path;
        break;
    }
}

if ($loader === null) {
    throw new RuntimeException('Impossibile trovare autoload.php in nessuno dei percorsi configurati.');
}

$loader->addPsr4('Algoritma\Bundle\DictionaryBundle\Tests\\', __DIR__);

// (new Dotenv('ORO_ENV', 'ORO_DEBUG'))
//    ->setProdEnvs(['prod', 'behat_test'])
//    ->bootEnv(\dirname(__DIR__) . '/../../.env-app', 'prod', ['test']);
EntityExtendTestInitializer::initialize();
