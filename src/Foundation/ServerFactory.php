<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Foundation;

use Mcp\Capability\Registry\Container;
use Mcp\Server;
use Psr\Log\LoggerInterface;

final class ServerFactory
{
    public static function create(
        string $projectRoot,
        string $packageRoot,
        Container $container,
        LoggerInterface $logger,
        string $name = 'Sockeon MCP Server',
        string $version = '2.0.0',
    ): Server {
        return Server::builder()
            ->setServerInfo($name, $version)
            ->setDiscovery($packageRoot, ['src/Capabilities'])
            ->setLogger($logger)
            ->setContainer($container)
            ->build();
    }
}
