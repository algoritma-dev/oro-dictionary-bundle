<?php

namespace Algoritma\Bundle\DictionaryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterTranslatorOnRegistryPass implements CompilerPassInterface
{
    public const REGISTRY_SERVICE_ID = 'algoritma_dictionary.translator.registry';
    public const TRANSLATOR_TAG = 'algoritma_dictionary.translator';

    public function process(ContainerBuilder $container): void
    {
        $translatorServices = $container->findTaggedServiceIds(self::TRANSLATOR_TAG);

        foreach ($translatorServices as $id => $tags) {
            $container->getDefinition(self::REGISTRY_SERVICE_ID)->addMethodCall('addTranslator', [$tags[0]['key'], new Reference($id)]);
        }
    }
}
