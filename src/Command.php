<?php

declare(strict_types=1);

namespace Keboola\DeveloperPortal\Cli;

use Keboola\DeveloperPortal\Client;
use Keboola\DeveloperPortal\Exception;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;

class Command extends SymfonyCommand
{
    protected function login(): Client
    {
        $username = (string) getenv('KBC_DEVELOPERPORTAL_USERNAME');
        if (!$username) {
            throw new Exception('KBC_DEVELOPERPORTAL_USERNAME not set.');
        }

        $password = (string) getenv('KBC_DEVELOPERPORTAL_PASSWORD');
        if (!$password) {
            throw new Exception('KBC_DEVELOPERPORTAL_PASSWORD not set.');
        }

        $url = (string) getenv('KBC_DEVELOPERPORTAL_URL');
        if (!$url) {
            $client = new Client();
        } else {
            $client = new Client($url);
        }

        $client->login($username, $password);
        return $client;
    }

    public static function getArgument(InputInterface $input, string $name): string
    {
        $value = $input->getArgument($name);
        if (is_scalar($value)) {
            return (string) $value;
        }
        throw new Exception(sprintf('Invalid value for argument "%s".', $name));
    }

    public static function getOption(InputInterface $input, string $name): string
    {
        $value = $input->getOption($name);
        if (is_scalar($value)) {
            return (string) $value;
        }
        throw new Exception(sprintf('Invalid value for option "%s".', $name));
    }
}
