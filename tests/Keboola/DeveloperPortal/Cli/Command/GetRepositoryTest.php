<?php
/**
 * Author: ondra@keboola.com
 * Date: 21/04/2017
 */
namespace Keboola\DeveloperPortal\Cli\Command\Test;

use Keboola\DeveloperPortal\Cli\Command\GetRepository;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class GetRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $application = new Application();
        $application->add(new GetRepository());
        $command = $application->find('ecr:get-repository');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),
            'vendor' => getenv('KBC_DEVELOPERPORTAL_TEST_VENDOR'),
            'app' => getenv('KBC_DEVELOPERPORTAL_TEST_APP')
        ));
        $this->assertEquals(0, $commandTester->getStatusCode());
        $this->assertContains(getenv('KBC_DEVELOPERPORTAL_TEST_APP'), $commandTester->getDisplay());
        $this->assertContains('ecr', $commandTester->getDisplay());
    }
}
