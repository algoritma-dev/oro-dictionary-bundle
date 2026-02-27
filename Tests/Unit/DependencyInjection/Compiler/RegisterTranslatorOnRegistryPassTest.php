<?php

namespace Algoritma\Bundle\DictionaryBundle\Tests\Unit\DependencyInjection\Compiler;

use Algoritma\Bundle\DictionaryBundle\DependencyInjection\Compiler\RegisterTranslatorOnRegistryPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/** @covers RegisterTranslatorOnRegistryPass */
class RegisterTranslatorOnRegistryPassTest extends TestCase
{
    private RegisterTranslatorOnRegistryPass $compiler;

    #[\Override]
    protected function setUp(): void
    {
        $this->compiler = new RegisterTranslatorOnRegistryPass();
    }
    public function testProcess()
    {
        $container = new ContainerBuilder();
        $container->register(RegisterTranslatorOnRegistryPass::REGISTRY_SERVICE_ID)
            ->setArguments([[]]);
        $container->register('translator_service_1')
            ->addTag(RegisterTranslatorOnRegistryPass::TRANSLATOR_TAG, ['key' => 'key_translator_1']);
        $container->register('translator_service_2')
            ->addTag(RegisterTranslatorOnRegistryPass::TRANSLATOR_TAG, ['key' => 'key_translator_2']);

        $this->compiler->process($container);

        self::assertEquals(
            [
                ['addTranslator', ['key_translator_1', new Reference('translator_service_1')]],
                ['addTranslator', ['key_translator_2', new Reference('translator_service_2')]]
            ],
            $container->getDefinition(RegisterTranslatorOnRegistryPass::REGISTRY_SERVICE_ID)->getMethodCalls()
        );
    }
}