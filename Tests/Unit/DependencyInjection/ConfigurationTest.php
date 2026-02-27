<?php

namespace Algoritma\Bundle\DictionaryBundle\Tests\Unit\DependencyInjection;

use Algoritma\Bundle\DictionaryBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;

/** @covers Configuration */
class ConfigurationTest extends TestCase
{
    private function processConfiguration(array $config): array
    {
        return new Processor()->processConfiguration(new Configuration(), $config);
    }

    /**
     * @dataProvider processConfigurationDataProvider
     */
    public function testProcessConfiguration(array $config, array $expected): void
    {
        $this->assertEquals($expected, $this->processConfiguration([$config]));
    }

    public function processConfigurationDataProvider(): array
    {
        return [
            'minimal_config'  => [
                ['api_key' => 'api_key'],
                ['api_key' => 'api_key', 'client' => 'google']
            ],
            'full_config'  => [
                ['api_key' => 'api_key', 'client' => 'test'],
                ['api_key' => 'api_key', 'client' => 'test']
            ],
        ];
    }

    /**
     * @dataProvider processInvalidConfigurationDataProvider
     */
    public function testProcessInvalidConfiguration(array $config, string $expectedException, string $expectedExceptionMessage): void
    {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $this->processConfiguration([$config]);
    }

    public function processInvalidConfigurationDataProvider(): array
    {
        return [
            'no_api_key' => [
                [],
                InvalidConfigurationException::class,
                'The child config "api_key" under "algoritma_dictionary" must be configured.'
            ],
            'empty_api_key' => [
                ['api_key' => ''],
                InvalidConfigurationException::class,
                'The path "algoritma_dictionary.api_key" cannot contain an empty value, but got "".'
            ],
        ];
    }
}