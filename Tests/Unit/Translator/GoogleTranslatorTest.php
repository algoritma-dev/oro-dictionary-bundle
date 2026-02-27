<?php

namespace Algoritma\Bundle\DictionaryBundle\Tests\Unit\Translator;

use Algoritma\Bundle\DictionaryBundle\Translator\GoogleTranslator;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Translate\V2\TranslateClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/** @covers GoogleTranslator */
class GoogleTranslatorTest extends TestCase
{
    private TranslateClient&MockObject $clientMock;
    private LoggerInterface&MockObject $logger;
    private GoogleTranslator $translator;

    public function testTrans_EmptyStringReturnEmptyString():void
    {
        $result = $this->translator->trans('', 'en', 'id');

        self::assertEquals('', $result);
    }

    public function testTrans_Trans():void
    {
        $this->clientMock->expects(self::once())->method('translate')
            ->with('Hello, World!', ['target' => 'id', 'source' => 'en'])
            ->willReturn(['text' => 'Halo, Dunia!']);

        $result = $this->translator->trans('Hello, World!', 'en', 'id');

        self::assertEquals('Halo, Dunia!', $result);
    }

    public function testTrans_TransPeformThrowExceptionButItCatchedAndReturnSameText():void
    {
        $this->clientMock->expects(self::once())->method('translate')
            ->with('Hello, World!', ['target' => 'id', 'source' => 'en'])
            ->willReturn(['text' => 'Hello, World!'])
            ->willThrowException(new ServiceException())
        ;

        $result = $this->translator->trans('Hello, World!', 'en', 'id');

        self::assertEquals('Hello, World!', $result);
    }

    public function testTrans_TransPeformThrowExceptionButItCatchedAndLogged():void
    {
        $this->clientMock->expects(self::once())->method('translate')
            ->with('Hello, World!', ['target' => 'id', 'source' => 'en'])
            ->willReturn(['text' => 'Hello, World!'])
            ->willThrowException(new ServiceException('Message to be logged'))
        ;

        $this->logger->expects(self::once())->method('error');

        $this->translator->trans('Hello, World!', 'en', 'id');
    }

    public function testTrans_TransPeformClientTrans():void
    {
        $this->clientMock->expects(self::once())->method('translate')
            ->with('Hello, World!', ['target' => 'id', 'source' => 'en'])
            ->willReturn(['text' => 'Halo, Dunia!']);

        $result = $this->translator->trans('Hello, World!', 'en', 'id');

        self::assertEquals('Halo, Dunia!', $result);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->logger = $this->createMock(LoggerInterface::class);
        $this->clientMock = $this->createMock(TranslateClient::class);
        $this->translator = new GoogleTranslator($this->clientMock, $this->logger);
    }
}