<?php

namespace Algoritma\Bundle\DictionaryBundle\Tests\Unit\DependencyInjection;

use Algoritma\Bundle\DictionaryBundle\DependencyInjection\AlgoritmaDictionaryExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/** @covers AlgoritmaDictionaryExtension */
class AlgoritmaDictionaryExtensionTest extends TestCase
{
    public function testLoad(): void
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.environment', 'prod');

        $extension = new AlgoritmaDictionaryExtension();
        $extension->load([], $container);

        self::assertNotEmpty($container->getDefinitions());
    }
}