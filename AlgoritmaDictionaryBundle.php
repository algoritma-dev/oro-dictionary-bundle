<?php

declare(strict_types=1);

namespace Algoritma\Bundle\DictionaryBundle;

use Algoritma\Bundle\DictionaryBundle\DependencyInjection\Compiler\RegisterTranslatorOnRegistryPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AlgoritmaDictionaryBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterTranslatorOnRegistryPass());
    }
}
