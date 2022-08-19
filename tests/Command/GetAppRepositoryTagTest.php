<?php

declare(strict_types=1);

namespace Keboola\DeveloperPortal\Cli\Tests\Command;

use Keboola\DeveloperPortal\Cli\Command\GetAppRepositoryTag;
use Keboola\DeveloperPortal\Cli\Command\UpdateAppRepositoryCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class GetAppRepositoryTagTest extends TestCase
{
    public function testExecute(): void
    {
        $application = new Application();
        $application->add(new GetAppRepositoryTag());
        $application->add(new UpdateAppRepositoryCommand());

        // update app repository
        $updateAppRepositoryCmd = $application->find('update-app-repository');
        $randomTag = rand(0, 10) . "." . rand(0, 10) . "." . rand(0, 10);
        $updateAppRepositoryCmdTester = new CommandTester($updateAppRepositoryCmd);
        $updateAppRepositoryCmdTester->execute([
            'command'  => $updateAppRepositoryCmd->getName(),
            'vendor' => getenv('KBC_DEVELOPERPORTAL_TEST_VENDOR'),
            'app' => getenv('KBC_DEVELOPERPORTAL_TEST_APP'),
            'tag' => $randomTag,
        ]);
        self::assertEquals(0, $updateAppRepositoryCmdTester->getStatusCode());
        self::assertStringContainsString(
            sprintf('"tag": "%s"', $randomTag),
            $updateAppRepositoryCmdTester->getDisplay()
        );

        // get app repository tag
        $command = $application->find(GetAppRepositoryTag::COMMAND_NAME);
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'vendor' => getenv('KBC_DEVELOPERPORTAL_TEST_VENDOR'),
            'app' => getenv('KBC_DEVELOPERPORTAL_TEST_APP'),
        ]);
        self::assertEquals(0, $commandTester->getStatusCode());
        self::assertEquals($randomTag, trim($commandTester->getDisplay()));
    }
}
