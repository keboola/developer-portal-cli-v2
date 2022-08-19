<?php

declare(strict_types=1);

namespace Keboola\DeveloperPortal\Cli\Tests\Command;

use Keboola\DeveloperPortal\Cli\Command\GetRepository;
use Keboola\DeveloperPortal\Cli\Command\UpdateAppPropertyCommand;
use Keboola\DeveloperPortal\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class UpdateAppPropertyCommandFileTest extends TestCase
{
    public function testExecute(): void
    {
        $application = new Application();
        $application->add(new UpdateAppPropertyCommand());
        $application->add(new GetRepository());

        $command = $application->find('update-app-property');

        $fileName = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('dev-portal-test');
        file_put_contents($fileName, uniqid('Long description') . "\n\n with newlines");
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'vendor' => getenv('KBC_DEVELOPERPORTAL_TEST_VENDOR'),
            'app' => getenv('KBC_DEVELOPERPORTAL_TEST_APP'),
            'property' => 'longDescription',
            '--value-from-file' => $fileName,
        ]);
        @unlink($fileName);
        self::assertEquals(0, $commandTester->getStatusCode());
        self::assertStringContainsString('"longDescription": "Long description', $commandTester->getDisplay());
    }

    public function testExecuteJson(): void
    {
        $application = new Application();
        $application->add(new UpdateAppPropertyCommand());
        $application->add(new GetRepository());

        $command = $application->find('update-app-property');

        $fileName = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('dev-portal-test');
        file_put_contents($fileName, uniqid('Long description') . "\n\n with newlines");
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'vendor' => getenv('KBC_DEVELOPERPORTAL_TEST_VENDOR'),
            'app' => getenv('KBC_DEVELOPERPORTAL_TEST_APP'),
            'property' => 'longDescription',
            '--value-from-file' => $fileName,
        ]);
        @unlink($fileName);
        self::assertEquals(0, $commandTester->getStatusCode());
        self::assertStringContainsString('"longDescription": "Long description', $commandTester->getDisplay());
    }

    public function testExecuteInvalidJson(): void
    {
        $application = new Application();
        $application->add(new UpdateAppPropertyCommand());
        $application->add(new GetRepository());

        $command = $application->find('update-app-property');

        $fileName = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('dev-portal-test');
        file_put_contents($fileName, uniqid('Long description') . "\n\n with newlines");
        $commandTester = new CommandTester($command);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The value is not a valid JSON: Syntax error');
        $commandTester->execute([
            'command'  => $command->getName(),
            'vendor' => getenv('KBC_DEVELOPERPORTAL_TEST_VENDOR'),
            'app' => getenv('KBC_DEVELOPERPORTAL_TEST_APP'),
            'property' => 'configurationSchema',
            '--value-from-file' => $fileName,
        ]);
    }

    public function testExecuteNonExistent(): void
    {
        $application = new Application();
        $application->add(new UpdateAppPropertyCommand());
        $application->add(new GetRepository());

        $command = $application->find('update-app-property');

        $commandTester = new CommandTester($command);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Cannot read file "invalid-filename"');
        $commandTester->execute([
            'command'  => $command->getName(),
            'vendor' => getenv('KBC_DEVELOPERPORTAL_TEST_VENDOR'),
            'app' => getenv('KBC_DEVELOPERPORTAL_TEST_APP'),
            'property' => 'longDescription',
            '--value-from-file' => 'invalid-filename',
        ]);
    }
}
