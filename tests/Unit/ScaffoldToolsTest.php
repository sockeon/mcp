<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sockeon\Mcp\Capabilities\Tools\Scaffold\ScaffoldTools;

final class ScaffoldToolsTest extends TestCase
{
    public function testScaffoldExampleReturnsChatTemplate(): void
    {
        $tool = new ScaffoldTools();
        $output = $tool->scaffoldExample('chat');

        self::assertStringContainsString('class', $output);
    }
}
