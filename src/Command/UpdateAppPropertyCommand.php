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
            ->addOption('value', null, InputOption::VALUE_REQUIRED, 'Value of the property')
            ->addOption(
                'json-value',
                null,
                InputOption::VALUE_REQUIRED,
                'Value of the property will be set to the JSON object parsed from the provided string'
            )
            ->addOption(
                'value-from-file',
                null,
                InputOption::VALUE_REQUIRED,
                'Value of the property will be set to the contents of the provided file'
            )
            ->addOption(
                'json-value-from-file',
                null,
                InputOption::VALUE_REQUIRED,
                'Value of the property will be set to the JSON object parsed from the contents of the provided file'
            )
            ->setDescription('Update arbitrary application property')
        ;
    }

    private function validateOptions(InputInterface $input): void
    {
        $allOptions = ['value', 'json-value', 'value-from-file', 'json-value-from-file'];
        $usedOptions = [];
        foreach ($allOptions as $optionName) {
            if ($input->getOption($optionName)) {
                $usedOptions[] = $optionName;
            }
        }
        if (count($usedOptions) > 1) {
            throw new Exception(sprintf('Use only one of "%s" options.', implode(', ', $allOptions)));
        }
        if (count($usedOptions) < 1) {
            throw new Exception(
                sprintf('Provide the property value using one of the "%s" options.', implode(', ', $allOptions))
            );
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->validateOptions($input);
        $json = false;

        if ($input->getOption('value-from-file') || $input->getOption('json-value-from-file')) {
            if ($input->getOption('value-from-file')) {
                $fileName = $input->getOption('value-from-file');
            } else {
                $fileName = $input->getOption('json-value-from-file');
                $json = true;
            }
            $value = @file_get_contents($fileName);
            if ($value === false) {
                throw new Exception(sprintf('Cannot read file "%s".', $fileName));
            }
        } else {
            if ($input->getOption('value')) {
                $value = $input->getOption('value');
            } else {
                $value = $input->getOption('json-value');
                $json = true;
            }
        }
        $name = (string) $input->getArgument('property');
        if ($json) {
            $value = json_decode($value, false);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("The value is not a valid JSON: " . json_last_error_msg());
            }
        }
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
