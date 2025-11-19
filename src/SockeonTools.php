<?php

/*
 * This file is part of the Sockeon MCP Server.
 *
 * Provides MCP tools for working with the Sockeon framework
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sockeon\Mcp;

use Mcp\Capability\Attribute\McpTool;

final class SockeonTools
{
    private StubLoader $stubLoader;

    public function __construct()
    {
        $this->stubLoader = new StubLoader();
    }
    #[McpTool(
        name: 'sockeon_generate_server',
        description: 'Generate a complete Sockeon server file with configuration and controller registration',
    )]
    public function generateServer(
        string $host = '0.0.0.0',
        int $port = 6001,
        bool $debug = true,
        ?string $controllerClass = null,
        ?array $corsOrigins = null,
    ): string {
        $corsConfig = '';
        if ($corsOrigins !== null) {
            $originsJson = json_encode($corsOrigins);
            $corsConfig = ",\n    'cors' => [\n        'allowed_origins' => {$originsJson}\n    ]";
        }

        $controllerRegistration = '';
        $controllerUse = '';
        if ($controllerClass !== null) {
            $controllerRegistration = "\n\n// Register controller\n\$server->registerController(new {$controllerClass}());";
            $controllerUse = "use App\\Controllers\\{$controllerClass};";
        }

        return $this->stubLoader->load('server/basic.php.stub', [
            'HOST' => $host,
            'PORT' => (string)$port,
            'DEBUG' => $debug ? 'true' : 'false',
            'CORS_CONFIG' => $corsConfig,
            'CONTROLLER_USE' => $controllerUse,
            'CONTROLLER_REGISTRATION' => $controllerRegistration,
        ]);
    }

    #[McpTool(
        name: 'sockeon_generate_controller',
        description: 'Generate a Sockeon controller class with WebSocket and HTTP route examples',
    )]
    public function generateController(
        string $controllerName,
        bool $includeWebSocket = true,
        bool $includeHttp = true,
        bool $includeRooms = false,
    ): string {
        $namespace = 'App\\Controllers';
        $websocketMethods = '';
        $httpMethods = '';
        $roomMethods = '';

        if ($includeWebSocket) {
            $websocketMethods = $this->stubLoader->load('controller/websocket-methods.php.stub');
        }

        if ($includeHttp) {
            $httpMethods = $this->stubLoader->load('controller/http-methods.php.stub');
        }

        if ($includeRooms) {
            $roomMethods = $this->stubLoader->load('controller/room-methods.php.stub');
        }

        $imports = "use Sockeon\Sockeon\Controllers\SocketController;\n";
        
        if ($includeWebSocket) {
            $imports .= "use Sockeon\Sockeon\WebSocket\Attributes\OnConnect;\n";
            $imports .= "use Sockeon\Sockeon\WebSocket\Attributes\OnDisconnect;\n";
            $imports .= "use Sockeon\Sockeon\WebSocket\Attributes\SocketOn;\n";
        }
        
        if ($includeHttp) {
            $imports .= "use Sockeon\Sockeon\Http\Attributes\HttpRoute;\n";
            $imports .= "use Sockeon\Sockeon\Http\Request;\n";
            $imports .= "use Sockeon\Sockeon\Http\Response;\n";
        }

        return $this->stubLoader->load('controller/basic.php.stub', [
            'NAMESPACE' => $namespace,
            'CONTROLLER_NAME' => $controllerName,
            'IMPORTS' => $imports,
            'WEBSOCKET_METHODS' => $websocketMethods,
            'HTTP_METHODS' => $httpMethods,
            'ROOM_METHODS' => $roomMethods,
        ]);
    }

    #[McpTool(
        name: 'sockeon_generate_config',
        description: 'Generate a ServerConfig configuration array with all available options',
    )]
    public function generateConfig(
        string $host = '0.0.0.0',
        int $port = 6001,
        bool $debug = false,
        ?array $corsOrigins = null,
        ?array $corsMethods = null,
        ?array $corsHeaders = null,
        ?string $authKey = null,
        ?array $rateLimit = null,
    ): string {
        $config = [
            'host' => $host,
            'port' => $port,
            'debug' => $debug,
        ];

        $cors = [];
        if ($corsOrigins !== null) {
            $cors['allowed_origins'] = $corsOrigins;
        }
        if ($corsMethods !== null) {
            $cors['allowed_methods'] = $corsMethods;
        }
        if ($corsHeaders !== null) {
            $cors['allowed_headers'] = $corsHeaders;
        }
        if (!empty($cors)) {
            $config['cors'] = $cors;
        }

        if ($authKey !== null) {
            $config['auth_key'] = $authKey;
        }

        if ($rateLimit !== null) {
            $config['rate_limit'] = $rateLimit;
        }

        $configStr = var_export($config, true);
        
        return $this->stubLoader->load('config/server.php.stub', [
            'CONFIG_ARRAY' => $configStr,
        ]);
    }

    #[McpTool(
        name: 'sockeon_list_validation_rules',
        description: 'List all available validation rules in Sockeon with their usage examples',
    )]
    public function listValidationRules(): string {
        $rules = [
            'Required' => 'Validates that a field is present and not empty',
            'StringRule' => 'Validates that a value is a string',
            'IntegerRule' => 'Validates that a value is an integer',
            'FloatRule' => 'Validates that a value is a float',
            'NumericRule' => 'Validates that a value is numeric',
            'BooleanRule' => 'Validates that a value is a boolean',
            'ArrayRule' => 'Validates that a value is an array',
            'EmailRule' => 'Validates that a value is a valid email address',
            'UrlRule' => 'Validates that a value is a valid URL',
            'AlphaRule' => 'Validates that a value contains only alphabetic characters',
            'AlphaNumericRule' => 'Validates that a value contains only alphanumeric characters',
            'MinRule' => 'Validates that a value meets a minimum requirement (length or value)',
            'MaxRule' => 'Validates that a value meets a maximum requirement (length or value)',
            'BetweenRule' => 'Validates that a value is between two values',
            'InRule' => 'Validates that a value is in a list of allowed values',
            'NotInRule' => 'Validates that a value is not in a list of disallowed values',
            'RegexRule' => 'Validates that a value matches a regular expression pattern',
            'JsonRule' => 'Validates that a value is valid JSON',
        ];

        $output = "Available Sockeon Validation Rules:\n\n";
        foreach ($rules as $rule => $description) {
            $output .= "- {$rule}: {$description}\n";
        }

        $output .= "\nExample usage in controller:\n\n";
        $output .= $this->stubLoader->load('validation/example.php.stub');

        return $output;
    }

    #[McpTool(
        name: 'sockeon_generate_websocket_handler',
        description: 'Generate a WebSocket event handler method with validation example',
    )]
    public function generateWebSocketHandler(
        string $eventName,
        ?array $validationRules = null,
        bool $broadcast = false,
        ?string $room = null,
    ): string {
        $validationCode = '';
        if ($validationRules !== null && !empty($validationRules)) {
            $rules = [];
            foreach ($validationRules as $field => $ruleList) {
                $ruleClasses = [];
                foreach ($ruleList as $rule) {
                    $ruleClasses[] = "new {$rule}()";
                }
                $rules[] = "            '{$field}' => [" . implode(', ', $ruleClasses) . "]";
            }
            $rulesStr = implode(",\n", $rules);
            
            $validationCode = $this->stubLoader->load('handler/validation.php.stub', [
                'VALIDATION_RULES' => $rulesStr,
            ]);
        }

        $broadcastCode = '';
        if ($broadcast) {
            if ($room !== null) {
                $broadcastCode = $this->stubLoader->load('handler/broadcast-room.php.stub', [
                    'EVENT_NAME' => $eventName,
                    'ROOM_NAME' => $room,
                ]);
            } else {
                $broadcastCode = $this->stubLoader->load('handler/broadcast-all.php.stub', [
                    'EVENT_NAME' => $eventName,
                ]);
            }
        } else {
            $broadcastCode = $this->stubLoader->load('handler/broadcast-response.php.stub', [
                'EVENT_NAME' => $eventName,
            ]);
        }

        $methodName = ucfirst(str_replace('.', '', $eventName));
        
        return $this->stubLoader->load('handler/websocket.php.stub', [
            'EVENT_NAME' => $eventName,
            'METHOD_NAME' => $methodName,
            'VALIDATION_CODE' => $validationCode,
            'BROADCAST_CODE' => $broadcastCode,
        ]);
    }

    #[McpTool(
        name: 'sockeon_generate_http_route',
        description: 'Generate an HTTP route handler method with path parameters and query parameters support',
    )]
    public function generateHttpRoute(
        string $method,
        string $path,
        bool $withPathParams = false,
        bool $withQueryParams = false,
        bool $withBody = false,
    ): string {
        $pathParamsCode = '';
        if ($withPathParams) {
            // Extract path parameters from path
            preg_match_all('/\{(\w+)\}/', $path, $matches);
            if (!empty($matches[1])) {
                $pathParamsCode = "\n        // Extract path parameters\n";
                foreach ($matches[1] as $param) {
                    $pathParamsCode .= "        \${$param} = \$request->getParam('{$param}');\n";
                }
            }
        }

        $queryParamsCode = '';
        if ($withQueryParams) {
            $queryParamsCode = $this->stubLoader->load('handler/http-query-params.php.stub');
        }

        $bodyCode = '';
        if ($withBody) {
            $bodyCode = $this->stubLoader->load('handler/http-body.php.stub');
        }

        $responseCode = '';
        if ($method === 'GET') {
            $responseCode = $this->stubLoader->load('handler/http-response-get.php.stub');
        } else {
            $responseCode = $this->stubLoader->load('handler/http-response-post.php.stub');
        }

        $methodName = strtolower($method) . str_replace(['/', '{', '}'], '', ucwords($path, '/{}'));

        return $this->stubLoader->load('handler/http.php.stub', [
            'METHOD' => $method,
            'PATH' => $path,
            'METHOD_NAME' => $methodName,
            'PATH_PARAMS_CODE' => $pathParamsCode,
            'QUERY_PARAMS_CODE' => $queryParamsCode,
            'BODY_CODE' => $bodyCode,
            'RESPONSE_CODE' => $responseCode,
        ]);
    }

    #[McpTool(
        name: 'sockeon_get_documentation',
        description: 'Get documentation links and key concepts for Sockeon framework',
    )]
    public function getDocumentation(?string $topic = null): string {
        $topics = [
            'quick-start' => 'Quick Start Guide - Build your first Sockeon application',
            'controllers' => 'Controllers - Handle WebSocket events and HTTP requests',
            'routing' => 'Routing - Attribute-based routing for WebSocket and HTTP',
            'middleware' => 'Middleware - Add authentication and request processing',
            'namespaces-rooms' => 'Namespaces and Rooms - Organize client grouping',
            'validation' => 'Validation - Validate and sanitize data',
            'rate-limiting' => 'Rate Limiting - Protect your server from abuse',
            'logging' => 'Logging - PSR-3 compliant logging system',
            'error-handling' => 'Error Handling - Comprehensive error handling',
        ];

        if ($topic !== null && isset($topics[$topic])) {
            return "Documentation for '{$topic}': {$topics[$topic]}\n\n" .
                   "Full documentation: https://sockeon.com/v2.0/{$topic}/\n";
        }

        $output = "Sockeon Framework Documentation\n\n";
        $output .= "Available topics:\n\n";
        foreach ($topics as $key => $description) {
            $output .= "- {$key}: {$description}\n";
        }

        $output .= "\nFull documentation: https://sockeon.com\n";
        $output .= "GitHub: https://github.com/sockeon/sockeon\n\n";
        $output .= "Key Features:\n";
        $output .= "- WebSocket and HTTP combined server\n";
        $output .= "- Attribute-based routing with PHP 8 attributes\n";
        $output .= "- Namespaces and rooms for client grouping\n";
        $output .= "- Middleware support for authentication\n";
        $output .= "- Built-in validation and sanitization\n";
        $output .= "- Rate limiting protection\n";
        $output .= "- PSR-3 logging\n";
        $output .= "- Zero dependencies (PHP core only)\n";

        return $output;
    }

    #[McpTool(
        name: 'sockeon_generate_example',
        description: 'Generate a complete example based on common use cases (chat, game, api, etc.)',
    )]
    public function generateExample(string $exampleType = 'chat'): string {
        return match ($exampleType) {
            'chat' => $this->generateChatExample(),
            'game' => $this->generateGameExample(),
            'api' => $this->generateApiExample(),
            'notification' => $this->generateNotificationExample(),
            default => $this->generateChatExample(),
        };
    }

    private function generateChatExample(): string {
        return $this->stubLoader->load('example/chat.php.stub');
    }

    private function generateGameExample(): string {
        return $this->stubLoader->load('example/game.php.stub');
    }

    private function generateApiExample(): string {
        return $this->stubLoader->load('example/api.php.stub');
    }

    private function generateNotificationExample(): string {
        return $this->stubLoader->load('example/notification.php.stub');
    }

    #[McpTool(
        name: 'sockeon_generate_rate_limit_config',
        description: 'Generate a complete rate limiting configuration with all options',
    )]
    public function generateRateLimitConfig(
        bool $enabled = true,
        int $maxHttpRequestsPerIp = 100,
        int $httpTimeWindow = 60,
        int $maxWebSocketMessagesPerClient = 200,
        int $webSocketTimeWindow = 60,
        int $maxConnectionsPerIp = 50,
        int $connectionTimeWindow = 60,
        int $maxGlobalConnections = 10000,
        int $burstAllowance = 10,
        array $whitelist = []
    ): string {
        $config = [
            'enabled' => $enabled,
            'maxHttpRequestsPerIp' => $maxHttpRequestsPerIp,
            'httpTimeWindow' => $httpTimeWindow,
            'maxWebSocketMessagesPerClient' => $maxWebSocketMessagesPerClient,
            'webSocketTimeWindow' => $webSocketTimeWindow,
            'maxConnectionsPerIp' => $maxConnectionsPerIp,
            'connectionTimeWindow' => $connectionTimeWindow,
            'maxGlobalConnections' => $maxGlobalConnections,
            'burstAllowance' => $burstAllowance,
        ];

        if (!empty($whitelist)) {
            $config['whitelist'] = $whitelist;
        }

        $configStr = var_export($config, true);

        return $this->stubLoader->load('rate-limit/config.php.stub', [
            'CONFIG_ARRAY' => $configStr,
        ]);
    }

    #[McpTool(
        name: 'sockeon_generate_cors_config',
        description: 'Generate a complete CORS configuration with all options',
    )]
    public function generateCorsConfig(
        array $allowedOrigins = ['*'],
        array $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'PATCH', 'HEAD'],
        array $allowedHeaders = ['Content-Type', 'X-Requested-With', 'Authorization'],
        bool $allowCredentials = false,
        int $maxAge = 86400
    ): string {
        $config = [
            'allowed_origins' => $allowedOrigins,
            'allowed_methods' => $allowedMethods,
            'allowed_headers' => $allowedHeaders,
            'allow_credentials' => $allowCredentials,
            'max_age' => $maxAge,
        ];

        $configStr = var_export($config, true);

        return $this->stubLoader->load('cors/config.php.stub', [
            'CONFIG_ARRAY' => $configStr,
        ]);
    }

    #[McpTool(
        name: 'sockeon_generate_middleware',
        description: 'Generate middleware classes for HTTP, WebSocket, or handshake',
    )]
    public function generateMiddleware(
        string $middlewareName,
        string $type = 'http' // 'http', 'websocket', or 'handshake'
    ): string {
        $namespace = 'App\\Middleware';
        
        $stubFile = match ($type) {
            'http' => 'middleware/http.php.stub',
            'websocket' => 'middleware/websocket.php.stub',
            'handshake' => 'middleware/handshake.php.stub',
            default => throw new \InvalidArgumentException("Invalid middleware type: {$type}"),
        };

        return $this->stubLoader->load($stubFile, [
            'NAMESPACE' => $namespace,
            'MIDDLEWARE_NAME' => $middlewareName,
        ]);
    }

    #[McpTool(
        name: 'sockeon_generate_websocket_client',
        description: 'Generate a WebSocket client code for connecting to Sockeon server',
    )]
    public function generateWebSocketClient(
        string $host = 'localhost',
        int $port = 6001,
        string $path = '/',
        int $timeout = 10
    ): string {
        return $this->stubLoader->load('client/websocket.php.stub', [
            'HOST' => $host,
            'PORT' => (string)$port,
            'PATH' => $path,
            'TIMEOUT' => (string)$timeout,
        ]);
    }

    #[McpTool(
        name: 'sockeon_generate_broadcast_handler',
        description: 'Generate code for broadcasting to rooms, namespaces, or all clients',
    )]
    public function generateBroadcastHandler(
        string $eventName,
        string $target = 'all', // 'all', 'room', 'namespace'
        ?string $targetName = null
    ): string {
        $code = '';
        
        switch ($target) {
            case 'all':
                $code = $this->stubLoader->load('handler/broadcast-all.php.stub', [
                    'EVENT_NAME' => $eventName,
                ]);
                break;
            case 'room':
                if ($targetName === null) {
                    $targetName = 'general';
                }
                $code = $this->stubLoader->load('handler/broadcast-room.php.stub', [
                    'EVENT_NAME' => $eventName,
                    'ROOM_NAME' => $targetName,
                ]);
                break;
            case 'namespace':
                if ($targetName === null) {
                    $targetName = '/';
                }
                $code = $this->stubLoader->load('handler/broadcast-namespace.php.stub', [
                    'EVENT_NAME' => $eventName,
                    'NAMESPACE_NAME' => $targetName,
                ]);
                break;
        }

        $methodName = ucfirst(str_replace('.', '', $eventName));
        
        return $this->stubLoader->load('handler/broadcast.php.stub', [
            'EVENT_NAME' => $eventName,
            'METHOD_NAME' => $methodName,
            'BROADCAST_CODE' => $code,
        ]);
    }

    #[McpTool(
        name: 'sockeon_generate_room_management',
        description: 'Generate code for room join/leave operations',
    )]
    public function generateRoomManagement(
        string $eventPrefix = 'room'
    ): string {
        return $this->stubLoader->load('handler/room-management.php.stub', [
            'PREFIX' => $eventPrefix,
        ]);
    }

    #[McpTool(
        name: 'sockeon_generate_namespace_management',
        description: 'Generate code for namespace operations',
    )]
    public function generateNamespaceManagement(): string {
        return $this->stubLoader->load('handler/namespace-management.php.stub');
    }

    #[McpTool(
        name: 'sockeon_generate_authentication',
        description: 'Generate authentication middleware and handlers',
    )]
    public function generateAuthentication(
        string $authType = 'key' // 'key' or 'token'
    ): string {
        $namespace = 'App\\Middleware';
        $middlewareName = $authType === 'key' ? 'WebSocketAuthMiddleware' : 'TokenAuthMiddleware';
        
        $stubFile = $authType === 'key' ? 'authentication/key.php.stub' : 'authentication/token.php.stub';
        
        return $this->stubLoader->load($stubFile, [
            'NAMESPACE' => $namespace,
            'MIDDLEWARE_NAME' => $middlewareName,
        ]);
    }

    #[McpTool(
        name: 'sockeon_generate_error_handler',
        description: 'Generate error handling code for controllers',
    )]
    public function generateErrorHandler(): string {
        return $this->stubLoader->load('error-handling/controller.php.stub');
    }

    #[McpTool(
        name: 'sockeon_generate_logging_setup',
        description: 'Generate custom logger setup code',
    )]
    public function generateLoggingSetup(): string {
        $namespace = 'App\\Logging';
        $loggerName = 'CustomLogger';
        
        return $this->stubLoader->load('logging/custom.php.stub', [
            'NAMESPACE' => $namespace,
            'LOGGER_NAME' => $loggerName,
        ]);
    }
}

