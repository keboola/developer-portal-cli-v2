<?php

declare(strict_types=1);

namespace Keboola\DeveloperPortal\Cli\Command;

use Keboola\DeveloperPortal\Cli\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use function json_encode;

class UpdateAppRepositoryCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('update-app-repository')
            ->addArgument('vendor', InputArgument::REQUIRED, 'Vendor ID')
            ->addArgument('app', InputArgument::REQUIRED, 'App ID')
            ->addArgument('tag', InputArgument::REQUIRED, 'Repository Version Tag')
            ->addArgument('type', InputArgument::OPTIONAL, 'Repository Type')
            ->addArgument('uri', InputArgument::OPTIONAL, 'Repository URI')
            ->addOption('configuration-format', null, InputOption::VALUE_REQUIRED, 'Configuration Format')
            ->setDescription('Update developer-portal app repository tag')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repository = [
            'tag' => $input->getArgument('tag'),
        ];
        if ($input->getArgument('uri')) {
            $repository['uri'] = $input->getArgument('uri');
        }
        if ($input->getArgument('type')) {
            $repository['type'] = $input->getArgument('type');
        }

        $params = [
            'repository' => $repository,
        ];

        if ($input->getOption('configuration-format') !== null) {
            $params['configurationFormat'] = $input->getOption('configuration-format');
        }

        $output->writeln(sprintf(
            'Updating application %s / %s:',
            self::getArgument($input, 'vendor'),
            self::getArgument($input, 'app')
        ));
        $output->writeln((string) json_encode($params, JSON_PRETTY_PRINT));

        $client = $this->login();
        $client->updateApp(
            self::getArgument($input, 'vendor'),
            self::getArgument($input, 'app'),
            $params
        );
        return 0;
    }
}
