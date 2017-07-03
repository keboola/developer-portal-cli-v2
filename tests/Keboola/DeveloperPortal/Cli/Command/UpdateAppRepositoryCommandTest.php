<?php

namespace Keboola\DeveloperPortal\Cli\Command\Test;

use Keboola\DeveloperPortal\Cli\Command\GetRepository;
use Keboola\DeveloperPortal\Cli\Command\UpdateAppRepositoryCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class UpdateAppRepositoryCommandTest extends TestCase
{
    public function testExecute()
    {
        $application = new Application();
        $application->add(new UpdateAppRepositoryCommand());
        $application->add(new GetRepository());

        $command = $application->find('update-app-repository');

        $randomTag = rand(0, 10) . "." . rand(0, 10) . "." . rand(0, 10);

        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),
            'vendor' => getenv('KBC_DEVELOPERPORTAL_TEST_VENDOR'),
            'app' => getenv('KBC_DEVELOPERPORTAL_TEST_APP'),
            'tag' => $randomTag
        ));
        $this->assertEquals(0, $commandTester->getStatusCode());
    }
}