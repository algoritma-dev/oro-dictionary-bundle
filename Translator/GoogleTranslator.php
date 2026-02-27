<?php

namespace Algoritma\Bundle\DictionaryBundle\Translator;

use Google\Cloud\Translate\V2\TranslateClient;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class GoogleTranslator implements TranslatorInterface
{
    public function __construct(
        private readonly TranslateClient $client = new TranslateClient(),
        private readonly LoggerInterface $logger = new Logger('google_translator_logger')
    )
    {
    }

    public function trans($text, string $sourceLanguage, string $targetLanguage): string
    {
        if($text === '') {
            return '';
        }

        $result = $text;

        try {
            $translation = $this->client->translate($text, ['source' => $sourceLanguage, 'target' => $targetLanguage]);

            if(!is_array($translation) || ! array_key_exists('text', $translation)) {
                $this->logger->error('Invalid response from Google Translate API', ['response' => $translation, 'text' => $text, 'source' => $sourceLanguage, 'target' => $targetLanguage]);
            }

            $result = $translation['text'] ?? $text;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $result;
    }
}
