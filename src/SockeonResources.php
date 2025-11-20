<?php

namespace Sockeon\Mcp;

use Mcp\Capability\Attribute\McpResource;
use Mcp\Capability\Attribute\McpResourceTemplate;
use Mcp\Exception\ResourceReadException;
use Sockeon\Mcp\Helpers\StubLoader;

final class SockeonResources
{
    private StubLoader $stubLoader;

    public function __construct()
    {
        $this->stubLoader = new StubLoader();
    }

    #[McpResource(
        uri: 'sockeon://docs/getting-started/quick-start',
        name: 'Quick-Start-Guide',
        description: 'Quick start guide for Sockeon framework',
        mimeType: 'text/markdown'
    )]
    public function getQuickStartGuide(): string
    {
        return $this->readDoc('getting-started/quick-start.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/getting-started/installation',
        name: 'Installation-Guide',
        description: 'Installation instructions for Sockeon',
        mimeType: 'text/markdown'
    )]
    public function getInstallationGuide(): string
    {
        return $this->readDoc('getting-started/installation.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/getting-started/basic-concepts',
        name: 'Basic-Concepts',
        description: 'Basic concepts and architecture of Sockeon',
        mimeType: 'text/markdown'
    )]
    public function getBasicConcepts(): string
    {
        return $this->readDoc('getting-started/basic-concepts.md');
    }


    #[McpResource(
        uri: 'sockeon://docs/core/controllers',
        name: 'Controllers-Documentation',
        description: 'Complete guide to Sockeon controllers',
        mimeType: 'text/markdown'
    )]
    public function getControllersDocs(): string
    {
        return $this->readDoc('core/controllers.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/core/routing',
        name: 'Routing-Documentation',
        description: 'Complete guide to Sockeon routing',
        mimeType: 'text/markdown'
    )]
    public function getRoutingDocs(): string
    {
        return $this->readDoc('core/routing.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/core/middleware',
        name: 'Middleware-Documentation',
        description: 'Complete guide to Sockeon middleware',
        mimeType: 'text/markdown'
    )]
    public function getMiddlewareDocs(): string
    {
        return $this->readDoc('core/middleware.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/core/namespaces-rooms',
        name: 'Namespaces-and-Rooms-Documentation',
        description: 'Complete guide to namespaces and rooms in Sockeon',
        mimeType: 'text/markdown'
    )]
    public function getNamespacesRoomsDocs(): string
    {
        return $this->readDoc('core/namespaces-rooms.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/core/server-configuration',
        name: 'Server-Configuration',
        description: 'Complete guide to server configuration',
        mimeType: 'text/markdown'
    )]
    public function getServerConfiguration(): string
    {
        return $this->readDoc('core/server-configuration.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/websocket/events',
        name: 'WebSocket-Events',
        description: 'Complete guide to WebSocket events',
        mimeType: 'text/markdown'
    )]
    public function getWebSocketEvents(): string
    {
        return $this->readDoc('websocket/events.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/websocket/connections',
        name: 'WebSocket-Connections',
        description: 'Complete guide to WebSocket connection management',
        mimeType: 'text/markdown'
    )]
    public function getWebSocketConnections(): string
    {
        return $this->readDoc('websocket/connections.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/websocket/broadcasting',
        name: 'WebSocket-Broadcasting',
        description: 'Complete guide to WebSocket broadcasting',
        mimeType: 'text/markdown'
    )]
    public function getWebSocketBroadcasting(): string
    {
        return $this->readDoc('websocket/broadcasting.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/websocket/client',
        name: 'WebSocket-Client',
        description: 'Complete guide to WebSocket PHP client',
        mimeType: 'text/markdown'
    )]
    public function getWebSocketClient(): string
    {
        return $this->readDoc('websocket/client.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/http/routing',
        name: 'HTTP-Routing',
        description: 'Complete guide to HTTP routing',
        mimeType: 'text/markdown'
    )]
    public function getHttpRouting(): string
    {
        return $this->readDoc('http/routing.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/http/request-response',
        name: 'HTTP-Request-and-Response',
        description: 'Complete guide to HTTP request and response handling',
        mimeType: 'text/markdown'
    )]
    public function getHttpRequestResponse(): string
    {
        return $this->readDoc('http/request-response.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/http/cors',
        name: 'CORS-Configuration',
        description: 'Complete guide to CORS configuration',
        mimeType: 'text/markdown'
    )]
    public function getCorsDocs(): string
    {
        return $this->readDoc('http/cors.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/validation/validation',
        name: 'Validation-Documentation',
        description: 'Complete guide to Sockeon validation',
        mimeType: 'text/markdown'
    )]
    public function getValidationDocs(): string
    {
        return $this->readDoc('validation/validation.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/validation/sanitization',
        name: 'Sanitization-Documentation',
        description: 'Complete guide to data sanitization',
        mimeType: 'text/markdown'
    )]
    public function getSanitizationDocs(): string
    {
        return $this->readDoc('validation/sanitization.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/advanced/rate-limiting',
        name: 'Rate-Limiting',
        description: 'Complete guide to rate limiting',
        mimeType: 'text/markdown'
    )]
    public function getRateLimitingDocs(): string
    {
        return $this->readDoc('advanced/rate-limiting.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/advanced/logging',
        name: 'Logging',
        description: 'Complete guide to logging',
        mimeType: 'text/markdown'
    )]
    public function getLoggingDocs(): string
    {
        return $this->readDoc('advanced/logging.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/advanced/error-handling',
        name: 'Error-Handling',
        description: 'Complete guide to error handling',
        mimeType: 'text/markdown'
    )]
    public function getErrorHandlingDocs(): string
    {
        return $this->readDoc('advanced/error-handling.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/api/server',
        name: 'Server-API-Reference',
        description: 'Complete Server API reference',
        mimeType: 'text/markdown'
    )]
    public function getServerApi(): string
    {
        return $this->readDoc('api/server.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/api/controller',
        name: 'Controller-API-Reference',
        description: 'Complete Controller API reference',
        mimeType: 'text/markdown'
    )]
    public function getControllerApi(): string
    {
        return $this->readDoc('api/controller.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/api/router',
        name: 'Router-API-Reference',
        description: 'Complete Router API reference',
        mimeType: 'text/markdown'
    )]
    public function getRouterApi(): string
    {
        return $this->readDoc('api/router.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/api/request',
        name: 'Request-API-Reference',
        description: 'Complete Request API reference',
        mimeType: 'text/markdown'
    )]
    public function getRequestApi(): string
    {
        return $this->readDoc('api/request.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/advanced/reverse-proxy-load-balancing',
        name: 'Reverse-Proxy-and-Load-Balancing',
        description: 'Complete guide to reverse proxy and load balancing configuration',
        mimeType: 'text/markdown'
    )]
    public function getReverseProxyGuide(): string
    {
        return $this->readDoc('advanced/reverse-proxy-load-balancing.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/api/response',
        name: 'Response-API-Reference',
        description: 'Complete Response API reference',
        mimeType: 'text/markdown'
    )]
    public function getResponseApi(): string
    {
        return $this->readDoc('api/response.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/api/client',
        name: 'Client-API-Reference',
        description: 'Complete Client API reference',
        mimeType: 'text/markdown'
    )]
    public function getClientApi(): string
    {
        return $this->readDoc('api/client.md');
    }

    #[McpResource(
        uri: 'sockeon://examples/chat',
        name: 'Chat-Example',
        description: 'Complete chat application example',
        mimeType: 'text/x-php'
    )]
    public function getChatExample(): string
    {
        return $this->stubLoader->load('example/chat.php.stub');
    }

    #[McpResource(
        uri: 'sockeon://examples/game',
        name: 'Game-Example',
        description: 'Complete game application example',
        mimeType: 'text/x-php'
    )]
    public function getGameExample(): string
    {
        return $this->stubLoader->load('example/game.php.stub');
    }

    #[McpResource(
        uri: 'sockeon://examples/api',
        name: 'API-Example',
        description: 'Complete REST API example',
        mimeType: 'text/x-php'
    )]
    public function getApiExample(): string
    {
        return $this->stubLoader->load('example/api.php.stub');
    }

    #[McpResource(
        uri: 'sockeon://examples/notification',
        name: 'Notification-Example',
        description: 'Complete notification system example',
        mimeType: 'text/x-php'
    )]
    public function getNotificationExample(): string
    {
        return $this->stubLoader->load('example/notification.php.stub');
    }

    #[McpResource(
        uri: 'sockeon://examples/basic-server',
        name: 'Basic-Server-Example',
        description: 'Basic server setup example',
        mimeType: 'text/markdown'
    )]
    public function getBasicServerExample(): string
    {
        return $this->readDoc('examples/basic-server.md');
    }

    #[McpResource(
        uri: 'sockeon://examples/http-server',
        name: 'HTTP-Server-Example',
        description: 'HTTP-only server example',
        mimeType: 'text/markdown'
    )]
    public function getHttpServerExample(): string
    {
        return $this->readDoc('examples/http-server.md');
    }

    #[McpResource(
        uri: 'sockeon://examples/hybrid-server',
        name: 'Hybrid-Server-Example',
        description: 'Hybrid WebSocket and HTTP server example',
        mimeType: 'text/markdown'
    )]
    public function getHybridServerExample(): string
    {
        return $this->readDoc('examples/hybrid-server.md');
    }

    #[McpResource(
        uri: 'sockeon://examples/basic-client',
        name: 'Basic-Client-Example',
        description: 'Basic WebSocket client example',
        mimeType: 'text/markdown'
    )]
    public function getBasicClientExample(): string
    {
        return $this->readDoc('examples/basic-client.md');
    }

    #[McpResource(
        uri: 'sockeon://validation-rules/list',
        name: 'Validation-Rules-List',
        description: 'Complete list of all validation rules',
        mimeType: 'application/json'
    )]
    public function getValidationRulesList(): array
    {
        return [
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
    }

    #[McpResourceTemplate(
        uriTemplate: 'sockeon://docs/{category}/{topic}',
        name: 'Documentation-Topic',
        description: 'Access Sockeon documentation by category and topic',
        mimeType: 'text/markdown'
    )]
    public function getDocumentationTopic(string $category, string $topic): string
    {
        $path = "{$category}/{$topic}";
        return $this->readDoc($path);
    }

    #[McpResourceTemplate(
        uriTemplate: 'sockeon://stubs/{type}/{name}',
        name: 'Code-Stub',
        description: 'Access code generation stubs',
        mimeType: 'text/x-php'
    )]
    public function getStub(string $type, string $name): string
    {
        return $this->stubLoader->load("{$type}/{$name}.php.stub");
    }

    #[McpResourceTemplate(
        uriTemplate: 'sockeon://validation-rule/{rule}',
        name: 'Validation-Rule',
        description: 'Get validation rule class code',
        mimeType: 'text/x-php'
    )]
    public function getValidationRule(string $rule): string
    {
        $ruleFile = __DIR__ . '/../../src/Validation/Rules/' . $rule . '.php';
        
        if (!file_exists($ruleFile)) {
            throw new ResourceReadException("Validation rule not found: {$rule}");
        }

        return file_get_contents($ruleFile);
    }

    private function readDoc(string $path): string
    {
        $url = "https://raw.githubusercontent.com/sockeon/docs/refs/heads/v2.0/{$path}";
        
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: Sockeon-MCP-Server/1.0',
                    'Accept: text/markdown,text/plain,*/*'
                ],
                'timeout' => 10,
                'follow_location' => true
            ]
        ]);
        
        $content = @file_get_contents($url, false, $context);
        
        if ($content === false) {
            throw new ResourceReadException("Failed to fetch documentation from: {$url}");
        }
        
        return $content;
    }
}
