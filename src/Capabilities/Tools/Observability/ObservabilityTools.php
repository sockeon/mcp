<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Capabilities\Tools\Observability;

use Mcp\Capability\Attribute\McpTool;
use Sockeon\Mcp\Domain\Generation\CodeGenerator;

final class ObservabilityTools
{
    public function __construct(
        private readonly CodeGenerator $generator = new CodeGenerator()
    ) {
    }

    #[McpTool(
        name: 'sockeon.observability.error_handler',
        description: 'Generate controller-level error handling boilerplate',
    )]
    public function generateErrorHandler(): string
    {
        return $this->generator->errorHandler();
    }

    #[McpTool(
        name: 'sockeon.observability.logging_setup',
        description: 'Generate custom logger class setup',
    )]
    public function generateLoggingSetup(): string
    {
        return $this->generator->loggingSetup();
    }
}
