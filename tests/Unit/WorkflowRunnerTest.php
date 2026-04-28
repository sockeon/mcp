<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sockeon\Mcp\Workflows\WorkflowRunner;

final class WorkflowRunnerTest extends TestCase
{
    public function testRunNormalizesMissingFields(): void
    {
        $steps = (new WorkflowRunner())->run([
            ['tool' => 'sockeon.scaffold.server'],
            ['id' => 'custom', 'title' => 'Custom', 'tool' => 'sockeon.config.server', 'args' => ['host' => '0.0.0.0'], 'phase' => 'config'],
        ]);

        self::assertSame('step_1', $steps[0]['id']);
        self::assertSame('Step 1', $steps[0]['title']);
        self::assertSame('default', $steps[0]['phase']);
        self::assertSame([], $steps[0]['args']);
        self::assertSame('custom', $steps[1]['id']);
        self::assertSame('config', $steps[1]['phase']);
    }
}
