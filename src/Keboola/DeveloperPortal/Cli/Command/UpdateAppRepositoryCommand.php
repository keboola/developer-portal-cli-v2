<?php

namespace Keboola\DeveloperPortal\Cli\Command;

use Keboola\DeveloperPortal\Cli\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateAppRepositoryCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('update-app-repository')
            ->addArgument('vendor', InputArgument::REQUIRED, 'Vendor ID')
            ->addArgument('app', InputArgument::REQUIRED, 'App ID')
            ->addArgument('tag', InputArgument::REQUIRED, 'Repository Version Tag')
            ->addArgument('type', InputArgument::OPTIONAL, 'Repository Type')
            ->addArgument('uri', InputArgument::OPTIONAL, 'Repository URI')
            ->setDescription('Update developer-portal app repository tag')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repository = [
            'tag' => $input->getArgument('tag')
        ];
        if ($input->getArgument('uri')) {
            $repository['uri'] = $input->getArgument('uri');
        }
        if ($input->getArgument('type')) {
            $repository['type'] = $input->getArgument('type');
        }

        $client = $this->login();
        $client->updateApp($input->getArgument('vendor'), $input->getArgument('app'), ["repository" => $repository]);
    }
}
