<?php

namespace Algoritma\Bundle\DictionaryBundle\Translator;

class TranslatorRegistry
{
    public function __construct(private array $translators = [])
    {
    }

    public function getTranslator(string $code): TranslatorInterface
    {
        return $this->translators[$code] ?? throw new \InvalidArgumentException('Translator not found');
    }

    public function addTranslator(string $code, TranslatorInterface $translator)
    {
        $this->translators[$code] = $translator;
    }
}
