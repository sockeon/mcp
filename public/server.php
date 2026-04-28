#!/usr/bin/env php
<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
use Mcp\Server\Transport\StdioTransport;
use Sockeon\Mcp\Foundation\McpApplication;

$transport = new StdioTransport();
$app = new McpApplication(
    projectRoot: __DIR__ . '/..',
    debug: (bool) ($_SERVER['DEBUG'] ?? false),
    fileLog: (bool) ($_SERVER['FILE_LOG'] ?? false),
);

$app->server()->run($transport);