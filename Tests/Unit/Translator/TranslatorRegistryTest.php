<?php

namespace Algoritma\Bundle\DictionaryBundle\Tests\Unit\Translator;

use Algoritma\Bundle\DictionaryBundle\Translator\DummyTranslator;
use Algoritma\Bundle\DictionaryBundle\Translator\TranslatorInterface;
use Algoritma\Bundle\DictionaryBundle\Translator\TranslatorRegistry;
use PHPUnit\Framework\TestCase;

/** @covers TranslatorRegistry */
class TranslatorRegistryTest extends TestCase
{
    private TranslatorRegistry $registry;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registry = new TranslatorRegistry();
    }

    public function testRegistry_TranslatorNotFound(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->registry->getTranslator('not_exists');
    }

    public function testRegistry_TranslatorFound(): void
    {
        $this->registry->addTranslator('test', new DummyTranslator());
        $translator = $this->registry->getTranslator('test');

        self::assertInstanceOf(TranslatorInterface::class, $translator);
    }

    public function testRegistry_MultipleTranslatorsFound(): void
    {
        $this->registry->addTranslator('test', new DummyTranslator());
        $this->registry->addTranslator('test2', new DummyTranslator());

        $test = $this->registry->getTranslator('test');
        $test2 = $this->registry->getTranslator('test2');

        self::assertInstanceOf(TranslatorInterface::class, $test);
        self::assertInstanceOf(TranslatorInterface::class, $test2);
    }

    public function testRegistry_canAddNewTranslator(): void
    {
        $this->registry->addTranslator('new_one', new DummyTranslator());

        $google = $this->registry->getTranslator('new_one');

        self::assertInstanceOf(TranslatorInterface::class, $google);
    }
}
