#!/usr/bin/env php
<?php

declare(strict_types=1);

// Prefer the consumer project's autoloader when installed via Composer.
$autoloadPaths = [
    __DIR__ . '/../../../autoload.php',
    __DIR__ . '/../vendor/autoload.php',
];

$autoloadLoaded = false;

foreach ($autoloadPaths as $autoloadPath) {
    if (is_file($autoloadPath)) {
        require_once $autoloadPath;
        $autoloadLoaded = true;
        break;
    }
}

if (!$autoloadLoaded) {
    fwrite(STDERR, "Sockeon MCP autoload file not found.\n");
    exit(1);
}

use Mcp\Server\Transport\StdioTransport;
use Sockeon\Mcp\Foundation\McpApplication;

$transport = new StdioTransport();
$projectRoot = getcwd() ?: dirname(__DIR__, 4);
$app = new McpApplication(
    projectRoot: $projectRoot,
    debug: (bool) ($_SERVER['DEBUG'] ?? false),
    fileLog: (bool) ($_SERVER['FILE_LOG'] ?? false),
);

$app->server()->run($transport);