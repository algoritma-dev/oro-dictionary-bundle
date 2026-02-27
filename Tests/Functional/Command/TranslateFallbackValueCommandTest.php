<?php

namespace Algoritma\Bundle\DictionaryBundle\Tests\Functional\Command;

use Algoritma\Bundle\DictionaryBundle\Command\TranslateFallbackValue;
use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/** @coversNothing */
class TranslateFallbackValueCommandTest extends KernelTestCase
{
    public function testExecute_withoutApiKey(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $tester = new CommandTester(new TranslateFallbackValue());
        $tester->execute(['client' => 'test']);
    }

    public function testExecute_withoutClientConfigShouldThrowException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $tester = new CommandTester(new TranslateFallbackValue());
        $tester->execute(['apiKey' => 'test']);
    }

    public function testExecute_withConfigShouldTranslateContent(): void
    {
        $fallbackValue = new LocalizedFallbackValue();
        $fallbackValue->setString('Ciao Mondo!');

        self::getContainer()->get('doctrine.orm.entity_manager')->persist($fallbackValue);
        self::getContainer()->get('doctrine.orm.entity_manager')->flush();

        $tester = new CommandTester(new TranslateFallbackValue());
        $tester->execute(['apiKey' => 'test', 'client' => 'test']);

        $value = self::getContainer()->get('doctrine.orm.entity_manager')->getRepository(LocalizedFallbackValue::class)->find($fallbackValue->getId());
        self::assertEquals('Halo Dunia!', $value->getString());
    }
}