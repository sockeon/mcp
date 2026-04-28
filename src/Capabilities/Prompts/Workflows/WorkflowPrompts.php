<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Capabilities\Prompts\Workflows;

use Mcp\Capability\Attribute\McpPrompt;
use Sockeon\Mcp\Workflows\WorkflowRunner;

final class WorkflowPrompts
{
    public function __construct(
        private readonly WorkflowRunner $runner = new WorkflowRunner()
    ) {
    }

    #[McpPrompt(
        name: 'sockeon_workflow_scaffold_realtime_app',
        description: 'Guided workflow to scaffold a realtime Sockeon application'
    )]
    public function scaffoldRealtimeApp(
        string $controllerName = 'AppController',
        string $host = '0.0.0.0',
        int $port = 6001
    ): array {
        $steps = $this->runner->run([
            [
                'id' => 'server_bootstrap',
                'title' => 'Create server bootstrap',
                'phase' => 'scaffold',
                'tool' => 'sockeon.scaffold.server',
                'args' => ['host' => $host, 'port' => $port, 'controllerClass' => $controllerName],
            ],
            [
                'id' => 'controller',
                'title' => 'Create controller scaffold',
                'phase' => 'scaffold',
                'tool' => 'sockeon.scaffold.controller',
                'args' => ['controllerName' => $controllerName, 'includeWebSocket' => true, 'includeHttp' => true],
            ],
            [
                'id' => 'websocket_handlers',
                'title' => 'Create websocket handlers',
                'phase' => 'realtime',
                'tool' => 'sockeon.realtime.websocket_handler',
                'args' => ['eventName' => 'chat.message', 'broadcastTarget' => 'all'],
            ],
            [
                'id' => 'server_config',
                'title' => 'Create server configuration',
                'phase' => 'config',
                'tool' => 'sockeon.config.server',
                'args' => ['host' => $host, 'port' => $port],
            ],
        ]);

        return [
            ['role' => 'assistant', 'content' => 'You are Sockeon Boost, a guided application scaffolder.'],
            ['role' => 'user', 'content' => "Run the realtime scaffold workflow using these steps:\n" . json_encode($steps, JSON_PRETTY_PRINT)],
        ];
    }

    #[McpPrompt(
        name: 'sockeon_workflow_harden_production_server',
        description: 'Guided workflow to harden a Sockeon server for production'
    )]
    public function hardenProductionServer(): array
    {
        $steps = $this->runner->run([
            [
                'id' => 'rate_limit',
                'title' => 'Configure rate limits',
                'phase' => 'security',
                'tool' => 'sockeon.config.rate_limit',
                'args' => ['enabled' => true],
            ],
            [
                'id' => 'cors',
                'title' => 'Configure CORS policy',
                'phase' => 'security',
                'tool' => 'sockeon.config.cors',
                'args' => ['allowedOrigins' => ['https://example.com'], 'allowCredentials' => true],
            ],
            [
                'id' => 'auth_middleware',
                'title' => 'Generate auth middleware',
                'phase' => 'security',
                'tool' => 'sockeon.security.authentication',
                'args' => ['authType' => 'token'],
            ],
            [
                'id' => 'logger',
                'title' => 'Generate custom logger',
                'phase' => 'observability',
                'tool' => 'sockeon.observability.logging_setup',
                'args' => [],
            ],
        ]);

        return [
            ['role' => 'assistant', 'content' => 'You are Sockeon Boost, focused on production safety and reliability.'],
            ['role' => 'user', 'content' => "Run the production hardening workflow using these steps:\n" . json_encode($steps, JSON_PRETTY_PRINT)],
        ];
    }
}
