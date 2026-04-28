<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Capabilities\Tools\Realtime;

use Mcp\Capability\Attribute\McpTool;
use Sockeon\Mcp\Domain\Generation\CodeGenerator;

final class RealtimeTools
{
    public function __construct(
        private readonly CodeGenerator $generator = new CodeGenerator()
    ) {
    }

    #[McpTool(
        name: 'sockeon_realtime_websocket_handler',
        description: 'Generate WebSocket event handler with optional validation and broadcast behavior',
    )]
    public function generateWebSocketHandler(
        string $eventName,
        ?array $validationRules = null,
        string $broadcastTarget = 'response',
        ?string $targetName = null,
    ): string {
        return $this->generator->websocketHandler($eventName, $validationRules, $broadcastTarget, $targetName);
    }

    #[McpTool(
        name: 'sockeon_realtime_http_route',
        description: 'Generate an HTTP route handler for Sockeon controller',
    )]
    public function generateHttpRoute(
        string $method,
        string $path,
        bool $withBody = false,
    ): string {
        return $this->generator->httpRoute($method, $path, $withBody);
    }

    #[McpTool(
        name: 'sockeon_realtime_room_management',
        description: 'Generate room join and leave handler boilerplate',
    )]
    public function generateRoomManagement(string $eventPrefix = 'room'): string
    {
        return $this->generator->roomManagement($eventPrefix);
    }

    #[McpTool(
        name: 'sockeon_realtime_namespace_management',
        description: 'Generate namespace management handler boilerplate',
    )]
    public function generateNamespaceManagement(): string
    {
        return $this->generator->namespaceManagement();
    }

    #[McpTool(
        name: 'sockeon_realtime_broadcast_handler',
        description: 'Generate dedicated broadcast handler for all, room, or namespace targets',
    )]
    public function generateBroadcastHandler(
        string $eventName,
        string $target = 'all',
        ?string $targetName = null,
    ): string {
        return $this->generator->broadcastHandler($eventName, $target, $targetName);
    }

    #[McpTool(
        name: 'sockeon_realtime_websocket_client',
        description: 'Generate PHP WebSocket client code for Sockeon server',
    )]
    public function generateWebSocketClient(
        string $host = 'localhost',
        int $port = 6001,
        string $path = '/',
        int $timeout = 10
    ): string {
        return $this->generator->websocketClient($host, $port, $path, $timeout);
    }
}
