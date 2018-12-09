<?php

declare(strict_types=1);

namespace Keboola\DeveloperPortal\Cli\Tests\Command;

use Keboola\DeveloperPortal\Cli\Command\GetLoginCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use PHPUnit\Framework\TestCase;

class GetLoginCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $application = new Application();
        $application->add(new GetLoginCommand());
        $command = $application->find('ecr:get-login');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'vendor' => getenv('KBC_DEVELOPERPORTAL_TEST_VENDOR'),
            'app' => getenv('KBC_DEVELOPERPORTAL_TEST_APP')
        ]);
        $this->assertEquals(0, $commandTester->getStatusCode());
        $this->assertContains('docker login -u AWS -p', $commandTester->getDisplay());
    }
}
