<?php
/**
 * Author: ondra@keboola.com
 * Date: 21/04/2017
 */
namespace Keboola\DeveloperPortal\Cli\Command\Test;

use Keboola\DeveloperPortal\Cli\Command\GetLoginCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class GetLoginCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $application = new Application();
        $application->add(new GetLoginCommand());
        $command = $application->find('ecr:get-login');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),
            'vendor' => getenv('KBC_DEVELOPERPORTAL_TEST_VENDOR'),
            'app' => getenv('KBC_DEVELOPERPORTAL_TEST_APP')
        ));
        $this->assertEquals(0, $commandTester->getStatusCode());
        $this->assertContains('docker login -u AWS -p', $commandTester->getDisplay());
    }
}
