<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Domain\Generation;

use InvalidArgumentException;
use Sockeon\Mcp\Domain\Templates\TemplateRenderer;

final class CodeGenerator
{
    public function __construct(
        private readonly TemplateRenderer $templates = new TemplateRenderer()
    ) {
    }

    public function scaffoldServer(
        string $host,
        int $port,
        bool $debug,
        ?string $controllerClass,
    ): string {
        $controllerRegistration = '';
        $controllerUse = '';

        if ($controllerClass !== null) {
            $controllerRegistration = "\n\n// Register controller\n\$server->registerController(new {$controllerClass}());";
            $controllerUse = "use App\\Controllers\\{$controllerClass};";
        }

        return $this->templates->render('server/basic.php.stub', [
            'HOST' => $host,
            'PORT' => (string) $port,
            'DEBUG' => $debug ? 'true' : 'false',
            'CORS_CONFIG' => '',
            'CONTROLLER_USE' => $controllerUse,
            'CONTROLLER_REGISTRATION' => $controllerRegistration,
        ]);
    }

    public function scaffoldController(
        string $controllerName,
        bool $includeWebSocket,
        bool $includeHttp,
        bool $includeRooms,
    ): string {
        $websocketMethods = $includeWebSocket ? $this->templates->render('controller/websocket-methods.php.stub') : '';
        $httpMethods = $includeHttp ? $this->templates->render('controller/http-methods.php.stub') : '';
        $roomMethods = $includeRooms ? $this->templates->render('controller/room-methods.php.stub') : '';

        $imports = "use Sockeon\\Sockeon\\Controllers\\SocketController;\n";
        if ($includeWebSocket) {
            $imports .= "use Sockeon\\Sockeon\\WebSocket\\Attributes\\OnConnect;\n";
            $imports .= "use Sockeon\\Sockeon\\WebSocket\\Attributes\\OnDisconnect;\n";
            $imports .= "use Sockeon\\Sockeon\\WebSocket\\Attributes\\SocketOn;\n";
        }
        if ($includeHttp) {
            $imports .= "use Sockeon\\Sockeon\\Http\\Attributes\\HttpRoute;\n";
            $imports .= "use Sockeon\\Sockeon\\Http\\Request;\n";
            $imports .= "use Sockeon\\Sockeon\\Http\\Response;\n";
        }

        return $this->templates->render('controller/basic.php.stub', [
            'NAMESPACE' => 'App\\Controllers',
            'CONTROLLER_NAME' => $controllerName,
            'IMPORTS' => $imports,
            'EXTRA_IMPORTS' => '',
            'WEBSOCKET_METHODS' => $websocketMethods,
            'HTTP_METHODS' => $httpMethods,
            'ROOM_METHODS' => $roomMethods,
        ]);
    }

    public function scaffoldExample(string $exampleType): string
    {
        return match ($exampleType) {
            'chat' => $this->templates->render('example/chat.php.stub'),
            'game' => $this->templates->render('example/game.php.stub'),
            'api' => $this->templates->render('example/api.php.stub'),
            'notification' => $this->templates->render('example/notification.php.stub'),
            default => $this->templates->render('example/chat.php.stub'),
        };
    }

    /**
     * @param array<string, mixed> $config
     */
    public function serverConfig(array $config): string
    {
        return $this->templates->render('config/server.php.stub', [
            'CONFIG_ARRAY' => var_export($config, true),
        ]);
    }

    /**
     * @param array<string, mixed> $config
     */
    public function rateLimitConfig(array $config): string
    {
        return $this->templates->render('rate-limit/config.php.stub', [
            'CONFIG_ARRAY' => var_export($config, true),
        ]);
    }

    /**
     * @param array<string, mixed> $config
     */
    public function corsConfig(array $config): string
    {
        return $this->templates->render('cors/config.php.stub', [
            'CONFIG_ARRAY' => var_export($config, true),
        ]);
    }

    public function reverseProxyConfig(string $domain, int $backendPort, string $backendHost): string
    {
        return $this->templates->render('config/nginx-reverse-proxy.conf.stub', [
            'DOMAIN' => $domain,
            'BACKEND_HOST' => $backendHost,
            'BACKEND_PORT' => (string) $backendPort,
            'LISTEN_DIRECTIVE' => '443 ssl http2',
            'SSL_CONFIG' => '',
        ]);
    }

    /**
     * @param array<string, array<int, string>>|null $validationRules
     */
    public function websocketHandler(
        string $eventName,
        ?array $validationRules,
        string $broadcastTarget,
        ?string $targetName,
    ): string {
        $validationCode = $this->buildValidationCode($validationRules);
        $validationImportHints = $validationCode === ''
            ? ''
            : $this->templates->render('handler/validation-import-hints.php.stub');
        $broadcastCode = $this->buildBroadcastCode($eventName, $broadcastTarget, $targetName);

        return $this->templates->render('handler/websocket.php.stub', [
            'EVENT_NAME' => $eventName,
            'METHOD_NAME' => $this->methodFromEvent($eventName),
            'VALIDATION_IMPORT_HINTS' => $validationImportHints,
            'VALIDATION_CODE' => $validationCode,
            'BROADCAST_CODE' => $broadcastCode,
        ]);
    }

    public function httpRoute(string $method, string $path, bool $withBody): string
    {
        $methodUpper = strtoupper($method);
        $responseCode = $methodUpper === 'GET'
            ? $this->templates->render('handler/http-response-get.php.stub')
            : $this->templates->render('handler/http-response-post.php.stub');

        return $this->templates->render('handler/http.php.stub', [
            'METHOD' => $methodUpper,
            'PATH' => $path,
            'METHOD_NAME' => $this->methodFromRoute($methodUpper, $path),
            'PATH_PARAMS_CODE' => '',
            'QUERY_PARAMS_CODE' => '',
            'BODY_CODE' => $withBody ? $this->templates->render('handler/http-body.php.stub') : '',
            'RESPONSE_CODE' => $responseCode,
        ]);
    }

    public function roomManagement(string $eventPrefix): string
    {
        return $this->templates->render('handler/room-management.php.stub', ['PREFIX' => $eventPrefix]);
    }

    public function namespaceManagement(): string
    {
        return $this->templates->render('handler/namespace-management.php.stub');
    }

    public function broadcastHandler(string $eventName, string $target, ?string $targetName): string
    {
        return $this->templates->render('handler/broadcast.php.stub', [
            'EVENT_NAME' => $eventName,
            'METHOD_NAME' => $this->methodFromEvent($eventName),
            'BROADCAST_CODE' => $this->buildBroadcastCode($eventName, $target, $targetName),
        ]);
    }

    public function websocketClient(string $host, int $port, string $path, int $timeout): string
    {
        return $this->templates->render('client/websocket.php.stub', [
            'HOST' => $host,
            'PORT' => (string) $port,
            'PATH' => $path,
            'TIMEOUT' => (string) $timeout,
        ]);
    }

    public function middleware(string $middlewareName, string $type): string
    {
        $stub = match ($type) {
            'http' => 'middleware/http.php.stub',
            'websocket' => 'middleware/websocket.php.stub',
            'handshake' => 'middleware/handshake.php.stub',
            default => throw new InvalidArgumentException("Unsupported middleware type: {$type}"),
        };

        return $this->templates->render($stub, [
            'NAMESPACE' => 'App\\Middleware',
            'MIDDLEWARE_NAME' => $middlewareName,
        ]);
    }

    public function authentication(string $authType): string
    {
        $stub = $authType === 'token' ? 'authentication/token.php.stub' : 'authentication/key.php.stub';
        $name = $authType === 'token' ? 'TokenAuthMiddleware' : 'WebSocketAuthMiddleware';

        return $this->templates->render($stub, [
            'NAMESPACE' => 'App\\Middleware',
            'MIDDLEWARE_NAME' => $name,
        ]);
    }

    public function validationExample(): string
    {
        return $this->templates->render('validation/example.php.stub');
    }

    public function errorHandler(): string
    {
        return $this->templates->render('error-handling/controller.php.stub');
    }

    public function loggingSetup(): string
    {
        return $this->templates->render('logging/custom.php.stub', [
            'NAMESPACE' => 'App\\Logging',
            'LOGGER_NAME' => 'CustomLogger',
        ]);
    }

    /**
     * @param array<string, array<int, string>>|null $validationRules
     */
    private function buildValidationCode(?array $validationRules): string
    {
        if (!is_array($validationRules) || $validationRules === []) {
            return '';
        }

        $rules = [];
        foreach ($validationRules as $field => $ruleList) {
            $list = [];
            foreach ($ruleList as $rule) {
                $list[] = "'" . (string) $rule . "'";
            }
            $rules[] = "                '{$field}' => [" . implode(', ', $list) . "]";
        }

        return $this->templates->render('handler/validation.php.stub', [
            'VALIDATION_RULES' => implode(",\n", $rules),
        ]);
    }

    private function buildBroadcastCode(string $eventName, string $target, ?string $targetName): string
    {
        return match ($target) {
            'all' => $this->templates->render('handler/broadcast-all.php.stub', ['EVENT_NAME' => $eventName]),
            'room' => $this->templates->render('handler/broadcast-room.php.stub', [
                'EVENT_NAME' => $eventName,
                'ROOM_NAME' => $targetName ?? 'general',
            ]),
            'namespace' => $this->templates->render('handler/broadcast-namespace.php.stub', [
                'EVENT_NAME' => $eventName,
                'NAMESPACE_NAME' => $targetName ?? '/',
            ]),
            default => $this->templates->render('handler/broadcast-response.php.stub', ['EVENT_NAME' => $eventName]),
        };
    }

    private function methodFromEvent(string $eventName): string
    {
        return ucfirst(str_replace('.', '', $eventName));
    }

    private function methodFromRoute(string $method, string $path): string
    {
        return strtolower($method) . str_replace(['/', '{', '}'], '', ucwords($path, '/{}'));
    }
}
