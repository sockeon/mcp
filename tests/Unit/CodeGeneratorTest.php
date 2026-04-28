<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sockeon\Mcp\Domain\Generation\CodeGenerator;
use Sockeon\Mcp\Domain\Templates\TemplateRenderer;

final class CodeGeneratorTest extends TestCase
{
    public function testGeneratesWebsocketHandlerWithValidation(): void
    {
        $generator = new CodeGenerator(new TemplateRenderer(__DIR__ . '/../../stubs'));

        $output = $generator->websocketHandler(
            eventName: 'chat.message',
            validationRules: ['message' => ['required', 'string']],
            broadcastTarget: 'all',
            targetName: null,
        );

        self::assertStringContainsString("#[SocketOn('chat.message')]", $output);
        self::assertStringContainsString("'message' => ['required', 'string']", $output);
    }
}
