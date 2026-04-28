<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Foundation;

use Mcp\Server;
use Psr\Log\LoggerInterface;

final class McpApplication
{
    private LoggerInterface $logger;

    public function __construct(
        private readonly string $projectRoot,
        private readonly bool $debug = false,
        private readonly bool $fileLog = false,
    ) {
        $this->logger = LoggerFactory::create($this->debug, $this->fileLog);
    }

    public function server(): Server
    {
        $container = ContainerFactory::create($this->logger);

        return ServerFactory::create(
            projectRoot: $this->projectRoot,
            container: $container,
            logger: $this->logger,
        );
    }
}
