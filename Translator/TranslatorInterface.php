<?php

namespace Algoritma\Bundle\DictionaryBundle\Translator;

interface TranslatorInterface
{
    public function trans($text, string $sourceLanguage, string $targetLanguage): string;
}
