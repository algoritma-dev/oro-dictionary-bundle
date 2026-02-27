<?php

namespace Algoritma\Bundle\DictionaryBundle\Translator;

use Google\Cloud\Core\Exception\ServiceException;
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

        try {
            $translation = $this->client->translate($text, ['source' => $sourceLanguage, 'target' => $targetLanguage]);

            return $translation['text'];
        } catch (ServiceException $e) {
            $this->logger->error($e->getMessage());

            return $text;
        }
    }
}