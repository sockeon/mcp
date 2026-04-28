<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Tests\Unit;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sockeon\Mcp\Domain\Templates\TemplateRenderer;

final class TemplateRendererTest extends TestCase
{
    public function testRenderServerStub(): void
    {
        $renderer = new TemplateRenderer(__DIR__ . '/../../stubs');
        $output = $renderer->render('server/basic.php.stub', [
            'HOST' => '127.0.0.1',
            'PORT' => '7000',
            'DEBUG' => 'true',
            'CORS_CONFIG' => '',
            'CONTROLLER_USE' => '',
            'CONTROLLER_REGISTRATION' => '',
        ]);

        self::assertStringContainsString('127.0.0.1', $output);
        self::assertStringContainsString('7000', $output);
    }

    public function testRenderThrowsForMissingStub(): void
    {
        $renderer = new TemplateRenderer(__DIR__ . '/../../stubs');

        $this->expectException(RuntimeException::class);
        $renderer->render('missing/not-found.stub');
    }
}
