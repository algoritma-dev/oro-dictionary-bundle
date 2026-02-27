<?php

namespace Algoritma\Bundle\DictionaryBundle\Tests\Functional\Command;

use Algoritma\Bundle\DictionaryBundle\Command\TranslateFallbackValueCommand;
use Algoritma\Bundle\DictionaryBundle\Translator\TranslationPerformer;
use Algoritma\Bundle\DictionaryBundle\Translator\TranslatorInterface;
use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Oro\Bundle\LocaleBundle\Manager\LocalizationManager;
use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @dbIsolationPerTest
 * @coversNothing
 */
class TranslateFallbackValueCommandTest extends WebTestCase
{
    public function testExecute_translateSingleStringContent(): void
    {
        $translatorMock = $this->createMock(TranslatorInterface::class);
        $translatorMock->method('trans')->willReturn('Halo Dunia!');

        $registry = self::getContainer()->get('algoritma_dictionary.translator.registry');
        $registry->addTranslator('test', $translatorMock);

        $fallbackValue = new LocalizedFallbackValue();
        $fallbackValue->setLocalization(self::getContainer()->get(LocalizationManager::class)->getDefaultLocalization());
        $fallbackValue->setString('Ciao Mondo!');

        self::getContainer()->get('doctrine.orm.entity_manager')->persist($fallbackValue);
        self::getContainer()->get('doctrine.orm.entity_manager')->flush();

        $tester = new CommandTester(new TranslateFallbackValueCommand(
            self::getContainer()->get('oro_entity.doctrine_helper'),
            new TranslationPerformer($registry, 'test')
        ));
        $tester->execute([]);

        $value = self::getContainer()->get('doctrine.orm.entity_manager')->getRepository(LocalizedFallbackValue::class)->find($fallbackValue->getId());
        self::assertEquals('Halo Dunia!', $value->getString());
    }

    public function testExecute_translateMultipleStringContent(): void
    {
        $translatorMock = $this->createMock(TranslatorInterface::class);
        $translatorMock->method('trans')->willReturn('Halo Dunia!');

        $registry = self::getContainer()->get('algoritma_dictionary.translator.registry');
        $registry->addTranslator('test', $translatorMock);

        $fallbackValue1 = new LocalizedFallbackValue();
        $fallbackValue1->setLocalization(self::getContainer()->get(LocalizationManager::class)->getDefaultLocalization());
        $fallbackValue1->setString('Ciao Mondo!');

        $fallbackValue2 = new LocalizedFallbackValue();
        $fallbackValue2->setLocalization(self::getContainer()->get(LocalizationManager::class)->getDefaultLocalization());
        $fallbackValue2->setString('Ciao Mondo 2!');

        self::getContainer()->get('doctrine.orm.entity_manager')->persist($fallbackValue1);
        self::getContainer()->get('doctrine.orm.entity_manager')->persist($fallbackValue2);
        self::getContainer()->get('doctrine.orm.entity_manager')->flush();

        $tester = new CommandTester(new TranslateFallbackValueCommand(
            self::getContainer()->get('oro_entity.doctrine_helper'),
            new TranslationPerformer($registry, 'test')
        ));
        $tester->execute([]);

        $value1 = self::getContainer()->get('doctrine.orm.entity_manager')->getRepository(LocalizedFallbackValue::class)->find($fallbackValue1->getId());
        self::assertEquals('Halo Dunia!', $value1->getString());

        $value2 = self::getContainer()->get('doctrine.orm.entity_manager')->getRepository(LocalizedFallbackValue::class)->find($fallbackValue2->getId());
        self::assertEquals('Halo Dunia!', $value2->getString());
    }
}
