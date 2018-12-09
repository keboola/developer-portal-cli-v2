<?php

declare(strict_types=1);

namespace Keboola\DeveloperPortal\Cli\Tests\Command;

use Keboola\DeveloperPortal\Cli\Command\GetRepository;
use Keboola\DeveloperPortal\Cli\Command\UpdateAppPropertyCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class UpdateAppPropertyCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $application = new Application();
        $application->add(new UpdateAppPropertyCommand());
        $application->add(new GetRepository());

        $command = $application->find('update-app-property');

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'vendor' => getenv('KBC_DEVELOPERPORTAL_TEST_VENDOR'),
            'app' => getenv('KBC_DEVELOPERPORTAL_TEST_APP'),
            'property' => 'shortDescription',
            'value' => uniqid('random-description'),
        ]);
        self::assertEquals(0, $commandTester->getStatusCode());
        self::assertContains('"shortDescription": "random-description', $commandTester->getDisplay());
    }

    public function testExecuteFile(): void
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
            'value' => $fileName,
            '--is-file' => 1
        ]);
        @unlink($fileName);
        self::assertEquals(0, $commandTester->getStatusCode());
        self::assertContains('"longDescription": "Long description', $commandTester->getDisplay());
    }
}
