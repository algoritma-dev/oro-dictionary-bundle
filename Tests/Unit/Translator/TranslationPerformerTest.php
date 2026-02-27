<?php

namespace Algoritma\Bundle\DictionaryBundle\Tests\Unit\Translator;

use Algoritma\Bundle\DictionaryBundle\Translator\TranslationPerformer;
use Algoritma\Bundle\DictionaryBundle\Translator\TranslatorInterface;
use Algoritma\Bundle\DictionaryBundle\Translator\TranslatorRegistry;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers TranslationPerformer */
class TranslationPerformerTest extends TestCase
{
    private TranslationPerformer $performer;
    private TranslatorRegistry $registry;
    private MockObject|TranslatorInterface $translator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->translator = $this->createMock(TranslatorInterface::class);
        $this->registry = new TranslatorRegistry(['test' => $this->translator]);
        $this->performer = new TranslationPerformer($this->registry, 'test');
    }

    public function testTranslationPerformer_emptyStringReturnEmptyString(): void
    {
        $this->translator->expects(self::never())->method('trans');

        self::assertSame('', $this->performer->trans('', 'en', 'en'));
    }

    public function testTranslationPerformer_testEnStringToEnReturnTheSame(): void
    {
        $this->translator->expects(self::once())->method('trans')
        ->with('Hello, World!', 'en', 'en')
        ->willReturn('Hello, World!');

        self::assertSame('Hello, World!', $this->performer->trans('Hello, World!', 'en', 'en'));
    }

    public function testTranslationPerformer_testItStringToEnReturnCorrectTranslation(): void
    {
        $this->translator->expects(self::once())->method('trans')
            ->with('Ciao, Mondo!', 'it', 'en')
            ->willReturn('Hello, World!');

        self::assertSame('Hello, World!', $this->performer->trans('Ciao, Mondo!', 'it', 'en'));
    }

    public function testTranslationPerformer_testEnStringToItReturnCorrectTranslation(): void
    {
        $this->translator->expects(self::once())->method('trans')
            ->with('Hello, World!', 'en', 'it')
            ->willReturn('Ciao, Mondo!');

        self::assertSame('Ciao, Mondo!', $this->performer->trans('Hello, World!', 'en', 'it'));
    }

    public function testTranslationPerformer_useCorrectTranslatorFromRegistryToTranslate(): void
    {
        $this->registry->addTranslator('de', $this->translator);
        $this->translator->expects(self::once())->method('trans')
            ->with('Hallo, Welt!', 'de', 'it')
            ->willReturn('Hello, World!');
        self::assertSame('Hello, World!', $this->performer->trans('Hallo, Welt!', 'de', 'it'));
    }
}
