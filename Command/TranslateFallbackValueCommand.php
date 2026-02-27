<?php

namespace Algoritma\Bundle\DictionaryBundle\Command;

use Algoritma\Bundle\DictionaryBundle\Translator\TranslationPerformer;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Oro\Bundle\LocaleBundle\Entity\LocalizedFallbackValue;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'algoritma:dictionary:translate-fallback-value', description: 'Translate fallback value content with translator client')]
class TranslateFallbackValueCommand extends Command
{
    public function __construct(
        private readonly DoctrineHelper $doctrineHelper,
        private readonly TranslationPerformer $translatorPerformer = new TranslationPerformer(),
    )
    {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $values = $this->doctrineHelper->getEntityRepository(LocalizedFallbackValue::class)->createQueryBuilder('v')
            ->where('v.string IS NOT NULL')
            ->andWhere('v.localization IS NOT NULL')
            ->getQuery()
            ->getResult();

        foreach ($values as $value) {
            dump($value->getString());
            $translated = $this->translate($value->getString());
            $value->setString($translated);
        }

        $this->doctrineHelper->getEntityManager(LocalizedFallbackValue::class)?->flush();

        return Command::SUCCESS;
    }

    private function translate(string $content): string
    {
        return $this->translatorPerformer->trans($content, 'en', 'id');
    }
}
