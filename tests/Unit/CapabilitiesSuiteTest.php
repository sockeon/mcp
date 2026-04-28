<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sockeon\Mcp\Capabilities\Prompts\Workflows\WorkflowPrompts;
use Sockeon\Mcp\Capabilities\Resources\Docs\DocsResources;
use Sockeon\Mcp\Capabilities\Resources\Stubs\StubResources;
use Sockeon\Mcp\Capabilities\Resources\Validation\ValidationResources;
use Sockeon\Mcp\Capabilities\Tools\Observability\ObservabilityTools;
use Sockeon\Mcp\Capabilities\Tools\Security\SecurityTools;

final class CapabilitiesSuiteTest extends TestCase
{
    public function testSecurityToolsAndValidationResourcesExposeRules(): void
    {
        $rulesFromTool = (new SecurityTools())->listValidationRules();
        $rulesFromResource = (new ValidationResources())->rules();

        self::assertArrayHasKey('Required', $rulesFromTool);
        self::assertSame($rulesFromTool['Required'], $rulesFromResource['Required']);
    }

    public function testSecurityMiddlewareGenerationFailsForUnsupportedType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new SecurityTools())->generateMiddleware('BadMiddleware', 'unknown');
    }

    public function testObservabilityStubsAreGenerated(): void
    {
        $tools = new ObservabilityTools();

        self::assertStringContainsString('handleError', $tools->generateErrorHandler());
        self::assertStringContainsString('class CustomLogger', $tools->generateLoggingSetup());
    }

    public function testStubAndDocsResourcesReturnExpectedContent(): void
    {
        $stub = (new StubResources())->stub('handler', 'websocket');
        $links = (new DocsResources())->links();

        self::assertStringContainsString('SocketOn', $stub);
        self::assertStringContainsString('github.com/sockeon/docs', $links);
        self::assertStringContainsString('Sockeon Docs Links', $links);
    }

    public function testWorkflowPromptsReturnValidMessageRolesAndSteps(): void
    {
        $prompt = new WorkflowPrompts();
        $scaffold = $prompt->scaffoldRealtimeApp();
        $harden = $prompt->hardenProductionServer();

        self::assertSame('assistant', $scaffold[0]['role']);
        self::assertSame('user', $scaffold[1]['role']);
        self::assertStringContainsString('sockeon.realtime.websocket_handler', $scaffold[1]['content']);
        self::assertStringContainsString('sockeon.config.rate_limit', $harden[1]['content']);
    }
}
