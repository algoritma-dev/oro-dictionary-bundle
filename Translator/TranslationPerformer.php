<?php

namespace Algoritma\Bundle\DictionaryBundle\Translator;

class TranslationPerformer
{
    public function __construct(
        private readonly TranslatorRegistry $translatorRegistry = new TranslatorRegistry(),
        private readonly string $translatorCode = 'google'
    )
    {
    }

    public function trans(string $string, string $sourceLanguage, string $targetLanguage): string
    {
        if($string === '') {
            return '';
        }

        return $this->translatorRegistry->getTranslator($this->translatorCode)->trans($string, $sourceLanguage, $targetLanguage);
    }
}