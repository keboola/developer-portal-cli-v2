<?php

declare(strict_types=1);

namespace Keboola\DeveloperPortal\Cli\Tests;

use Keboola\DeveloperPortal\Cli\Command;
use Keboola\DeveloperPortal\Exception;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Console\Input\Input;

class CommandTest extends TestCase
{
    public function testGetArgumentInvalid(): void
    {
        $inputMock = $this->createMock(Input::class);
        $inputMock->method('getArgument')->willReturn(new stdClass());
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid value for argument "test".');
        Command::getArgument($inputMock, 'test');
    }

    public function testGetArgumentValid(): void
    {
        $inputMock = $this->createMock(Input::class);
        $inputMock->method('getArgument')->willReturn(12);
        self::assertSame('12', Command::getArgument($inputMock, 'test'));
    }

    public function testGetOptionInvalid(): void
    {
        $inputMock = $this->createMock(Input::class);
        $inputMock->method('getOption')->willReturn(new stdClass());
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid value for option "test".');
        Command::getOption($inputMock, 'test');
    }

    public function testGetOptionValid(): void
    {
        $inputMock = $this->createMock(Input::class);
        $inputMock->method('getOption')->willReturn(12);
        self::assertSame('12', Command::getOption($inputMock, 'test'));
    }
}
