<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sockeon\Mcp\Capabilities\Tools\Realtime\RealtimeTools;

final class RealtimeToolsTest extends TestCase
{
    public function testGenerateWebsocketHandlerWithNamespaceBroadcastAndValidation(): void
    {
        $output = (new RealtimeTools())->generateWebSocketHandler(
            eventName: 'chat.message',
            validationRules: ['message' => ['required', 'string']],
            broadcastTarget: 'namespace',
            targetName: '/chat',
        );

        self::assertStringContainsString("#[SocketOn('chat.message')]", $output);
        self::assertStringContainsString("'message' => ['required', 'string']", $output);
        self::assertStringContainsString("/chat", $output);
    }

    public function testGenerateHttpRouteIncludesBodySectionForPost(): void
    {
        $output = (new RealtimeTools())->generateHttpRoute('POST', '/api/items', true);

        self::assertStringContainsString("#[HttpRoute('POST', '/api/items')]", $output);
        self::assertStringContainsString('$request->all()', $output);
    }

    public function testGenerateWebsocketClientUsesRunLoop(): void
    {
        $output = (new RealtimeTools())->generateWebSocketClient('localhost', 6001, '/', 10);

        self::assertStringContainsString('$client->run();', $output);
    }
}
