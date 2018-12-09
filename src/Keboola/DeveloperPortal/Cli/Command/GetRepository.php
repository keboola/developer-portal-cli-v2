<?php

declare(strict_types=1);

namespace Keboola\DeveloperPortal\Cli\Command;

use Keboola\DeveloperPortal\Cli\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetRepository extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('ecr:get-repository')
            ->addArgument('vendor', InputArgument::REQUIRED, 'Vendor ID')
            ->addArgument('app', InputArgument::REQUIRED, 'App ID')
            ->setDescription('Get AWS ECR repository URI')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $client = $this->login();
        $repository = $client->getAppRepository($input->getArgument('vendor'), $input->getArgument('app'));
        $output->writeln("{$repository["registry"]}/{$repository["repository"]}");
    }
}
