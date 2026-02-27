<?php

namespace Algoritma\Bundle\DictionaryBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterTranslatorOnRegistryPass
{
    public const REGISTRY_SERVICE_ID = 'algoritma_dictionary.translator.registry';
    public const TRANSLATOR_TAG = 'algoritma_dictionary.translator';

    public function process(ContainerBuilder $param): void
    {
        $translatorServices = $param->findTaggedServiceIds(self::TRANSLATOR_TAG);

        foreach ($translatorServices as $id => $tags) {
            $param->getDefinition(self::REGISTRY_SERVICE_ID)->addMethodCall('addTranslator', [$tags[0]['key'], new Reference($id)]);
        }
    }
}