<?php

declare(strict_types=1);

namespace Keboola\DeveloperPortal\Cli\Command;

use Keboola\DeveloperPortal\Cli\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetLoginCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('ecr:get-login')
            ->addArgument('vendor', InputArgument::REQUIRED, 'Vendor ID')
            ->addArgument('app', InputArgument::REQUIRED, 'App ID')
            ->setDescription('Get login command for AWS ECR repository')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $client = $this->login();
        $repository = $client->getAppRepository($input->getArgument('vendor'), $input->getArgument('app'));
        $output->writeln(sprintf(
            "docker login -u %s -p %s %s",
            $repository["credentials"]["username"],
            $repository["credentials"]["password"],
            $repository["registry"]
        ));
    }
}
