<?php

namespace Sockeon\Mcp;

use Mcp\Capability\Attribute\McpPrompt;

final class SockeonPrompts
{
    #[McpPrompt(
        name: 'create_chat_server',
        description: 'Generate a complete chat server with WebSocket and HTTP endpoints'
    )]
    public function createChatServer(
        string $controllerName = 'ChatController',
        string $host = '0.0.0.0',
        int $port = 6001
    ): array {
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Generate a complete chat server application.'
            ],
            [
                'role' => 'user',
                'content' => "Create a complete Sockeon chat server with:\n" .
                    "- Controller name: {$controllerName}\n" .
                    "- Server host: {$host}\n" .
                    "- Server port: {$port}\n" .
                    "- WebSocket events for chat messages and room joining\n" .
                    "- HTTP endpoints for status and client management\n" .
                    "\nUse the sockeon_generate_example tool with exampleType='chat' to get the base code, then customize it."
            ]
        ];
    }

    #[McpPrompt(
        name: 'create_game_server',
        description: 'Generate a complete game server with rooms and namespaces'
    )]
    public function createGameServer(
        string $controllerName = 'GameController',
        string $namespace = '/game'
    ): array {
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Generate a complete game server application.'
            ],
            [
                'role' => 'user',
                'content' => "Create a complete Sockeon game server with:\n" .
                    "- Controller name: {$controllerName}\n" .
                    "- Namespace: {$namespace}\n" .
                    "- Game creation and joining functionality\n" .
                    "- Room-based game sessions\n" .
                    "- Player management\n" .
                    "\nUse the sockeon_generate_example tool with exampleType='game' to get the base code, then customize it."
            ]
        ];
    }

    #[McpPrompt(
        name: 'create_rest_api',
        description: 'Generate a REST API server with CRUD operations'
    )]
    public function createRestApi(
        string $controllerName = 'ApiController',
        string $resourceName = 'users'
    ): array {
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Generate a complete REST API server.'
            ],
            [
                'role' => 'user',
                'content' => "Create a complete Sockeon REST API server with:\n" .
                    "- Controller name: {$controllerName}\n" .
                    "- Resource: {$resourceName}\n" .
                    "- GET /api/{$resourceName} - List all resources\n" .
                    "- GET /api/{$resourceName}/{id} - Get single resource\n" .
                    "- POST /api/{$resourceName} - Create resource\n" .
                    "- PUT /api/{$resourceName}/{id} - Update resource\n" .
                    "- DELETE /api/{$resourceName}/{id} - Delete resource\n" .
                    "\nUse the sockeon_generate_example tool with exampleType='api' to get the base code, then customize it."
            ]
        ];
    }

    #[McpPrompt(
        name: 'add_validation',
        description: 'Add validation to a WebSocket event handler or HTTP route'
    )]
    public function addValidation(
        string $eventOrRoute,
        array $fields = []
    ): array {
        $fieldsList = empty($fields) 
            ? 'all required fields' 
            : implode(', ', $fields);

        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Add validation to event handlers and routes.'
            ],
            [
                'role' => 'user',
                'content' => "Add validation to: {$eventOrRoute}\n" .
                    "- Fields to validate: {$fieldsList}\n" .
                    "\nUse the sockeon_list_validation_rules tool to see available validation rules, " .
                    "then use sockeon_generate_websocket_handler or sockeon_generate_http_route with validation rules."
            ]
        ];
    }

    #[McpPrompt(
        name: 'setup_middleware',
        description: 'Set up authentication and request processing middleware'
    )]
    public function setupMiddleware(
        string $type = 'authentication'
    ): array {
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Set up middleware for request processing.'
            ],
            [
                'role' => 'user',
                'content' => "Set up {$type} middleware for Sockeon server.\n" .
                    "\nRead the middleware documentation from sockeon://docs/middleware resource " .
                    "and create appropriate middleware classes."
            ]
        ];
    }

    #[McpPrompt(
        name: 'configure_cors',
        description: 'Configure CORS settings for the Sockeon server'
    )]
    public function configureCors(
        array $allowedOrigins = ['*'],
        array $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
        array $allowedHeaders = ['Content-Type', 'Authorization']
    ): array {
        $origins = implode(', ', $allowedOrigins);
        $methods = implode(', ', $allowedMethods);
        $headers = implode(', ', $allowedHeaders);

        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Configure CORS for the server.'
            ],
            [
                'role' => 'user',
                'content' => "Configure CORS for Sockeon server with:\n" .
                    "- Allowed origins: {$origins}\n" .
                    "- Allowed methods: {$methods}\n" .
                    "- Allowed headers: {$headers}\n" .
                    "\nUse the sockeon_generate_config tool to generate server configuration with CORS settings."
            ]
        ];
    }

    #[McpPrompt(
        name: 'implement_rate_limiting',
        description: 'Implement rate limiting for the Sockeon server'
    )]
    public function implementRateLimiting(
        int $maxRequests = 100,
        int $windowSeconds = 60
    ): array {
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Implement rate limiting.'
            ],
            [
                'role' => 'user',
                'content' => "Implement rate limiting for Sockeon server:\n" .
                    "- Max requests: {$maxRequests}\n" .
                    "- Time window: {$windowSeconds} seconds\n" .
                    "\nRead the rate limiting documentation and use sockeon_generate_config tool " .
                    "to add rate limit configuration."
            ]
        ];
    }

    #[McpPrompt(
        name: 'create_custom_controller',
        description: 'Create a custom controller with specific requirements'
    )]
    public function createCustomController(
        string $controllerName,
        array $websocketEvents = [],
        array $httpRoutes = [],
        bool $useRooms = false
    ): array {
        $eventsList = empty($websocketEvents) 
            ? 'none specified' 
            : implode(', ', $websocketEvents);
        $routesList = empty($httpRoutes) 
            ? 'none specified' 
            : implode(', ', $httpRoutes);

        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Create custom controllers.'
            ],
            [
                'role' => 'user',
                'content' => "Create a custom Sockeon controller:\n" .
                    "- Controller name: {$controllerName}\n" .
                    "- WebSocket events: {$eventsList}\n" .
                    "- HTTP routes: {$routesList}\n" .
                    "- Use rooms: " . ($useRooms ? 'yes' : 'no') . "\n" .
                    "\nUse sockeon_generate_controller tool to generate the base controller, " .
                    "then add specific event handlers and routes using sockeon_generate_websocket_handler " .
                    "and sockeon_generate_http_route tools."
            ]
        ];
    }

    #[McpPrompt(
        name: 'setup_complete_server',
        description: 'Set up a complete production-ready Sockeon server with all features'
    )]
    public function setupCompleteServer(
        string $host = '0.0.0.0',
        int $port = 6001
    ): array {
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Set up a complete production-ready server.'
            ],
            [
                'role' => 'user',
                'content' => "Set up a complete production-ready Sockeon server with:\n" .
                    "- Host: {$host}, Port: {$port}\n" .
                    "- Rate limiting enabled\n" .
                    "- CORS configured\n" .
                    "- Authentication middleware\n" .
                    "- Custom logging\n" .
                    "- Error handling\n" .
                    "- Multiple controllers\n" .
                    "\nUse all relevant tools to generate the complete setup."
            ]
        ];
    }

    #[McpPrompt(
        name: 'implement_realtime_features',
        description: 'Implement real-time features with WebSocket broadcasting and rooms'
    )]
    public function implementRealtimeFeatures(
        array $features = ['chat', 'notifications']
    ): array {
        $featuresList = implode(', ', $features);
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Implement real-time features.'
            ],
            [
                'role' => 'user',
                'content' => "Implement real-time features: {$featuresList}\n" .
                    "\nUse sockeon_generate_broadcast_handler and sockeon_generate_room_management tools " .
                    "to create WebSocket handlers for real-time communication."
            ]
        ];
    }

    #[McpPrompt(
        name: 'create_rest_api_with_validation',
        description: 'Create a REST API with comprehensive validation'
    )]
    public function createRestApiWithValidation(
        string $resource = 'users',
        array $fields = []
    ): array {
        $fieldsList = empty($fields) ? 'standard fields' : implode(', ', $fields);
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Create REST APIs with validation.'
            ],
            [
                'role' => 'user',
                'content' => "Create a REST API for {$resource} with:\n" .
                    "- Fields: {$fieldsList}\n" .
                    "- Full CRUD operations\n" .
                    "- Input validation using sockeon_list_validation_rules\n" .
                    "- Error handling\n" .
                    "\nUse sockeon_generate_http_route and validation tools."
            ]
        ];
    }

    #[McpPrompt(
        name: 'secure_websocket_connections',
        description: 'Secure WebSocket connections with authentication and authorization'
    )]
    public function secureWebSocketConnections(
        string $authMethod = 'key'
    ): array {
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Secure WebSocket connections.'
            ],
            [
                'role' => 'user',
                'content' => "Secure WebSocket connections using {$authMethod} authentication:\n" .
                    "- Generate authentication middleware\n" .
                    "- Configure server with auth key\n" .
                    "- Add handshake middleware\n" .
                    "- Handle authentication errors\n" .
                    "\nUse sockeon_generate_authentication tool."
            ]
        ];
    }

    #[McpPrompt(
        name: 'optimize_performance',
        description: 'Optimize Sockeon server performance with rate limiting and connection management'
    )]
    public function optimizePerformance(): array {
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Optimize server performance.'
            ],
            [
                'role' => 'user',
                'content' => "Optimize Sockeon server performance:\n" .
                    "- Configure rate limiting\n" .
                    "- Set connection limits\n" .
                    "- Optimize broadcasting\n" .
                    "- Configure cleanup intervals\n" .
                    "\nUse sockeon_generate_rate_limit_config tool and read rate limiting documentation."
            ]
        ];
    }

    #[McpPrompt(
        name: 'integrate_external_services',
        description: 'Integrate external services with Sockeon server'
    )]
    public function integrateExternalServices(
        array $services = ['database', 'cache']
    ): array {
        $servicesList = implode(', ', $services);
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Integrate external services.'
            ],
            [
                'role' => 'user',
                'content' => "Integrate external services: {$servicesList}\n" .
                    "- Create service classes\n" .
                    "- Inject into controllers\n" .
                    "- Handle service errors\n" .
                    "- Use dependency injection\n" .
                    "\nGenerate controller code with service integration."
            ]
        ];
    }

    #[McpPrompt(
        name: 'monitor_and_log',
        description: 'Set up comprehensive monitoring and logging'
    )]
    public function monitorAndLog(): array {
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Set up monitoring and logging.'
            ],
            [
                'role' => 'user',
                'content' => "Set up comprehensive monitoring and logging:\n" .
                    "- Custom logger implementation\n" .
                    "- Log all events and errors\n" .
                    "- Monitor connection counts\n" .
                    "- Track performance metrics\n" .
                    "\nUse sockeon_generate_logging_setup and read logging documentation."
            ]
        ];
    }

    #[McpPrompt(
        name: 'handle_errors_gracefully',
        description: 'Implement comprehensive error handling across the application'
    )]
    public function handleErrorsGracefully(): array {
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Implement error handling.'
            ],
            [
                'role' => 'user',
                'content' => "Implement comprehensive error handling:\n" .
                    "- Error handlers for WebSocket events\n" .
                    "- Try-catch in HTTP routes\n" .
                    "- Custom error responses\n" .
                    "- Error logging\n" .
                    "\nUse sockeon_generate_error_handler and read error handling documentation."
            ]
        ];
    }

    #[McpPrompt(
        name: 'build_multi_tenant_app',
        description: 'Build a multi-tenant application using namespaces'
    )]
    public function buildMultiTenantApp(): array {
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Build multi-tenant applications.'
            ],
            [
                'role' => 'user',
                'content' => "Build a multi-tenant application:\n" .
                    "- Use namespaces for tenant isolation\n" .
                    "- Namespace-based routing\n" .
                    "- Tenant-specific rooms\n" .
                    "- Namespace management APIs\n" .
                    "\nUse sockeon_generate_namespace_management and read namespaces documentation."
            ]
        ];
    }

    #[McpPrompt(
        name: 'create_websocket_client_app',
        description: 'Create a PHP client application to connect to Sockeon server'
    )]
    public function createWebSocketClientApp(
        string $host = 'localhost',
        int $port = 6001
    ): array {
        return [
            [
                'role' => 'system',
                'content' => 'You are a Sockeon framework expert. Create WebSocket client applications.'
            ],
            [
                'role' => 'user',
                'content' => "Create a PHP WebSocket client application:\n" .
                    "- Connect to {$host}:{$port}\n" .
                    "- Listen for events\n" .
                    "- Emit events\n" .
                    "- Handle reconnections\n" .
                    "\nUse sockeon_generate_websocket_client and read client documentation."
            ]
        ];
    }
}

