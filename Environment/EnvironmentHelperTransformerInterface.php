<?php declare(strict_types=1);

namespace Algoritma\Bundle\DictionaryBundle\Environment;

interface EnvironmentHelperTransformerInterface
{
    public static function transform(EnvironmentHelperTransformerData $data): void;
}
