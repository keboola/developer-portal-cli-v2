<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/.env.local')) {
    (new Dotenv())->usePutenv(true)->bootEnv(dirname(__DIR__).'/.env.local', 'dev', []);
}

$requiredEnvs = ['KBC_DEVELOPERPORTAL_TEST_VENDOR', 'KBC_DEVELOPERPORTAL_TEST_APP',
    ];
foreach ($requiredEnvs as $env) {
    if (empty(getenv($env))) {
        throw new Exception(sprintf('The "%s" environment variable is empty.', $env));
    }
}
