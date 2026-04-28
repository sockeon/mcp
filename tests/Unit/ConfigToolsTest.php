<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sockeon\Mcp\Capabilities\Tools\Config\ConfigTools;

final class ConfigToolsTest extends TestCase
{
    public function testGenerateServerConfigIncludesOptionalSections(): void
    {
        $output = (new ConfigTools())->generateServerConfig(
            host: '127.0.0.1',
            port: 7000,
            debug: true,
            corsOrigins: ['https://example.com'],
            corsMethods: ['GET'],
            corsHeaders: ['Authorization'],
            authKey: 'secret',
            rateLimit: ['enabled' => true],
            trustProxy: true,
            proxyHeaders: ['X-Forwarded-For'],
            healthCheckPath: '/healthz',
        );

        self::assertStringContainsString("'host' => '127.0.0.1'", $output);
        self::assertStringContainsString("'auth_key' => 'secret'", $output);
        self::assertStringContainsString("'rate_limit' =>", $output);
        self::assertStringContainsString("'health_check_path' => '/healthz'", $output);
    }

    public function testGenerateCorsConfigIncludesCredentialsAndMaxAge(): void
    {
        $output = (new ConfigTools())->generateCorsConfig(
            allowedOrigins: ['https://example.com'],
            allowedMethods: ['GET'],
            allowedHeaders: ['Authorization'],
            allowCredentials: true,
            maxAge: 1200,
        );

        self::assertStringContainsString("'allow_credentials' => true", $output);
        self::assertStringContainsString("'max_age' => 1200", $output);
    }
}
