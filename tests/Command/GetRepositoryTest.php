<?php

declare(strict_types=1);

namespace Keboola\DeveloperPortal\Cli\Tests\Command;

use Keboola\DeveloperPortal\Cli\Command\GetRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class GetRepositoryTest extends TestCase
{
    public function testExecute(): void
    {
        $application = new Application();
        $application->add(new GetRepository());
        $command = $application->find('ecr:get-repository');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command'  => $command->getName(),
            'vendor' => getenv('KBC_DEVELOPERPORTAL_TEST_VENDOR'),
            'app' => getenv('KBC_DEVELOPERPORTAL_TEST_APP')
        ]);
        $this->assertEquals(0, $commandTester->getStatusCode());
        $this->assertContains(getenv('KBC_DEVELOPERPORTAL_TEST_APP'), $commandTester->getDisplay());
        $this->assertContains('ecr', $commandTester->getDisplay());
    }
}
