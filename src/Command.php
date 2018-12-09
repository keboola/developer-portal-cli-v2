<?php

declare(strict_types=1);

namespace Keboola\DeveloperPortal\Cli;

use Keboola\DeveloperPortal\Client;
use Keboola\DeveloperPortal\Exception;

class Command extends \Symfony\Component\Console\Command\Command
{
    protected function login(): Client
    {
        $username = getenv('KBC_DEVELOPERPORTAL_USERNAME');
        if (!$username) {
            throw new Exception("KBC_DEVELOPERPORTAL_USERNAME not set.");
        }

        $password = getenv('KBC_DEVELOPERPORTAL_PASSWORD');
        if (!$password) {
            throw new Exception("KBC_DEVELOPERPORTAL_PASSWORD not set.");
        }

        $url = getenv('KBC_DEVELOPERPORTAL_URL');
        if (!$url) {
            $client = new Client();
        } else {
            $client = new Client($url);
        }

        $client->login($username, $password);
        return $client;
    }
}
