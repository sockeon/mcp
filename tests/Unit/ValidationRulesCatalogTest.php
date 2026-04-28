<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sockeon\Mcp\Domain\Validation\ValidationRulesCatalog;

final class ValidationRulesCatalogTest extends TestCase
{
    public function testCatalogContainsRequiredAndStringRule(): void
    {
        $rules = (new ValidationRulesCatalog())->all();

        self::assertArrayHasKey('Required', $rules);
        self::assertArrayHasKey('StringRule', $rules);
    }
}
