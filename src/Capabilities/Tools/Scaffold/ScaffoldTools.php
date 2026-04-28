<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Capabilities\Tools\Scaffold;

use Mcp\Capability\Attribute\McpTool;
use Sockeon\Mcp\Domain\Generation\CodeGenerator;

final class ScaffoldTools
{
    public function __construct(
        private readonly CodeGenerator $generator = new CodeGenerator()
    ) {
    }

    #[McpTool(
        name: 'sockeon_scaffold_server',
        description: 'Generate a complete Sockeon server bootstrap with optional controller registration',
    )]
    public function scaffoldServer(
        string $host = '0.0.0.0',
        int $port = 6001,
        bool $debug = true,
        ?string $controllerClass = null,
    ): string {
        return $this->generator->scaffoldServer($host, $port, $debug, $controllerClass);
    }

    #[McpTool(
        name: 'sockeon_scaffold_controller',
        description: 'Generate Sockeon controller boilerplate with optional websocket/http/room handlers',
    )]
    public function scaffoldController(
        string $controllerName,
        bool $includeWebSocket = true,
        bool $includeHttp = true,
        bool $includeRooms = false,
    ): string {
        return $this->generator->scaffoldController(
            controllerName: $controllerName,
            includeWebSocket: $includeWebSocket,
            includeHttp: $includeHttp,
            includeRooms: $includeRooms,
        );
    }

    #[McpTool(
        name: 'sockeon_scaffold_example',
        description: 'Generate a complete example application (chat, game, api, notification)',
    )]
    public function scaffoldExample(string $exampleType = 'chat'): string
    {
        return $this->generator->scaffoldExample($exampleType);
    }
}
