<?php

declare(strict_types=1);

namespace Keboola\DeveloperPortal\Cli\Tests\Command;

use Keboola\DeveloperPortal\Cli\Command\GetRepository;
use Keboola\DeveloperPortal\Cli\Command\UpdateAppRepositoryCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class UpdateAppRepositoryCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $application = new Application();
        $application->add(new UpdateAppRepositoryCommand());
        $application->add(new GetRepository());

        $command = $application->find('update-app-repository');

        $randomTag = rand(0, 10) . '.' . rand(0, 10) . '.' . rand(0, 10);

        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'vendor' => getenv('KBC_DEVELOPERPORTAL_TEST_VENDOR'),
            'app' => getenv('KBC_DEVELOPERPORTAL_TEST_APP'),
            'tag' => $randomTag,
            '--configuration-format' => 'json',
        ]);
        $this->assertEquals(0, $commandTester->getStatusCode());
        $this->assertStringContainsString('"configurationFormat": "json"', $commandTester->getDisplay());
    }
}
