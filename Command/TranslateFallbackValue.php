<?php

namespace Algoritma\Bundle\DictionaryBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'algoritma:dictionary:translate-fallback-value', description: 'Translate fallback value content with translator client')]
class TranslateFallbackValue extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        throw new \InvalidArgumentException('Not implemented');
    }
}