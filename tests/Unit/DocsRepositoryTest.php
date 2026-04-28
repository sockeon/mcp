<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sockeon\Mcp\Domain\Docs\DocsRepository;

final class DocsRepositoryTest extends TestCase
{
    public function testLinksContainsCoreDocsEntries(): void
    {
        $links = (new DocsRepository())->links();

        self::assertArrayHasKey('quick-start', $links);
        self::assertArrayHasKey('controllers', $links);
        self::assertStringContainsString('github.com/sockeon/docs', $links['quick-start']);
        self::assertStringContainsString('.md', $links['quick-start']);
    }

    public function testResolveTopicPathSupportsReverseProxyAlias(): void
    {
        $path = (new DocsRepository())->resolveTopicPath('advanced', 'reverse-proxy');

        self::assertSame('advanced/reverse-proxy-load-balancing.md', $path);
    }

    public function testResolveTopicPathAcceptsHtmlSuffix(): void
    {
        $path = (new DocsRepository())->resolveTopicPath('http', 'routing.html');

        self::assertSame('http/routing.md', $path);
    }
}
