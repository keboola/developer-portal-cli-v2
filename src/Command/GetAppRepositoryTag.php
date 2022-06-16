<?php

declare(strict_types=1);

namespace Keboola\DeveloperPortal\Cli\Command;

use Keboola\DeveloperPortal\Cli\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetAppRepositoryTag extends Command
{
    public const COMMAND_NAME = 'get-app-repository-tag';

    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->addArgument('vendor', InputArgument::REQUIRED, 'Vendor ID')
            ->addArgument('app', InputArgument::REQUIRED, 'App ID')
            ->setDescription('Get app repository tag')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $client = $this->login();
        $component = $client->getAppDetail($input->getArgument('vendor'), $input->getArgument('app'));
        $output->writeln($component['repository']['tag'] ?? '');
    }
}
