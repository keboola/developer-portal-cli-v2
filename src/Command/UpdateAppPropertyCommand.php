<?php

declare(strict_types=1);

namespace Keboola\DeveloperPortal\Cli\Command;

use Keboola\DeveloperPortal\Cli\Command;
use Keboola\DeveloperPortal\Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateAppPropertyCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('update-app-property')
            ->addArgument('vendor', InputArgument::REQUIRED, 'Vendor ID')
            ->addArgument('app', InputArgument::REQUIRED, 'App ID')
            ->addArgument('property', InputArgument::REQUIRED, 'Name of the property to update')
            ->addArgument('value', InputArgument::REQUIRED, 'Value of the property to update')
            ->addOption('is-file', null, InputOption::VALUE_REQUIRED, 'Read value from file')
            ->setDescription('Update arbitrary application property')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $value = $input->getArgument('value');
        if ($input->getOption('is-file')) {
            $newValue = @file_get_contents($value);
            if ($newValue === false) {
                throw new Exception(sprintf('Cannot read file "%s".', $value));
            }
            $value = $newValue;
        }
        $name = $input->getArgument('property');
        $params = [$name => $value];

        $output->writeln(sprintf(
            'Updating application %s / %s:',
            $input->getArgument('vendor'),
            $input->getArgument('app')
        ));
        $output->writeln(\json_encode($params, JSON_PRETTY_PRINT));

        $client = $this->login();
        $client->updateApp($input->getArgument('vendor'), $input->getArgument('app'), $params);
    }
}
