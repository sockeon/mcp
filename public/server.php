#!/usr/bin/env php
<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/bootstrap.php';

use Mcp\Server;
use Mcp\Server\Transport\StdioTransport;

$server = Server::builder()
    ->setServerInfo('Sockeon MCP Server', '1.0.0')
    ->setDiscovery(__DIR__ . '/..', ['src'])
    ->setLogger(logger())
    ->setContainer(container())
    ->build();

$transport = new StdioTransport();

$server->run($transport);