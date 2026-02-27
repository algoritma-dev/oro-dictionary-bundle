<?php

namespace Algoritma\Bundle\DictionaryBundle\Translator;

class DummyTranslator implements TranslatorInterface
{
    public function trans($text, string $sourceLanguage, string $targetLanguage): string
    {
        return '';
    }
}


