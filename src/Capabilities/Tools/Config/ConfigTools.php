<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Capabilities\Tools\Config;

use Mcp\Capability\Attribute\McpTool;
use Sockeon\Mcp\Domain\Generation\CodeGenerator;

final class ConfigTools
{
    public function __construct(
        private readonly CodeGenerator $generator = new CodeGenerator()
    ) {
    }

    #[McpTool(
        name: 'sockeon_config_server',
        description: 'Generate Sockeon server config array with optional CORS/auth/rate limiting',
    )]
    public function generateServerConfig(
        string $host = '0.0.0.0',
        int $port = 6001,
        bool $debug = false,
        ?array $corsOrigins = null,
        ?array $corsMethods = null,
        ?array $corsHeaders = null,
        ?string $authKey = null,
        ?array $rateLimit = null,
        bool|array|null $trustProxy = null,
        ?array $proxyHeaders = null,
        ?string $healthCheckPath = null,
    ): string {
        $config = ['host' => $host, 'port' => $port, 'debug' => $debug];

        $cors = [];
        if (is_array($corsOrigins)) {
            $cors['allowed_origins'] = $corsOrigins;
        }
        if (is_array($corsMethods)) {
            $cors['allowed_methods'] = $corsMethods;
        }
        if (is_array($corsHeaders)) {
            $cors['allowed_headers'] = $corsHeaders;
        }
        if ($cors !== []) {
            $config['cors'] = $cors;
        }
        if ($authKey !== null) {
            $config['auth_key'] = $authKey;
        }
        if (is_array($rateLimit)) {
            $config['rate_limit'] = $rateLimit;
        }
        if ($trustProxy !== null) {
            $config['trust_proxy'] = $trustProxy;
        }
        if (is_array($proxyHeaders)) {
            $config['proxy_headers'] = $proxyHeaders;
        }
        if ($healthCheckPath !== null) {
            $config['health_check_path'] = $healthCheckPath;
        }

        return $this->generator->serverConfig($config);
    }

    #[McpTool(
        name: 'sockeon_config_rate_limit',
        description: 'Generate rate limiting configuration for HTTP and WebSocket traffic',
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
        array $whitelist = [],
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
        if ($whitelist !== []) {
            $config['whitelist'] = $whitelist;
        }

        return $this->generator->rateLimitConfig($config);
    }

    #[McpTool(
        name: 'sockeon_config_cors',
        description: 'Generate complete CORS configuration with origins/methods/headers',
    )]
    public function generateCorsConfig(
        array $allowedOrigins = ['*'],
        array $allowedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'PATCH', 'HEAD'],
        array $allowedHeaders = ['Content-Type', 'X-Requested-With', 'Authorization'],
        bool $allowCredentials = false,
        int $maxAge = 86400,
    ): string {
        $config = [
            'allowed_origins' => $allowedOrigins,
            'allowed_methods' => $allowedMethods,
            'allowed_headers' => $allowedHeaders,
            'allow_credentials' => $allowCredentials,
            'max_age' => $maxAge,
        ];

        return $this->generator->corsConfig($config);
    }

    #[McpTool(
        name: 'sockeon_config_reverse_proxy',
        description: 'Generate nginx reverse proxy configuration for Sockeon deployments',
    )]
    public function generateReverseProxyConfig(
        string $domain = 'example.com',
        int $backendPort = 6001,
        string $backendHost = '127.0.0.1',
    ): string {
        return $this->generator->reverseProxyConfig($domain, $backendPort, $backendHost);
    }
}
