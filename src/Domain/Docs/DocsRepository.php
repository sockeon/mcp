<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Domain\Docs;

use RuntimeException;

final class DocsRepository
{
    private const BASE_URL = 'https://raw.githubusercontent.com/sockeon/docs/refs/heads/v2.0/';
    private const DOCS_GITHUB_BASE = 'https://github.com/sockeon/docs/blob/v2.0/';

    /**
     * @var array<string, string>
     */
    private array $fallbackDocs = [
        'getting-started/quick-start.md' => "# Quick Start\n\nSee full docs at https://github.com/sockeon/docs/blob/v2.0/getting-started/quick-start.md.\n",
        'getting-started/installation.md' => "# Installation\n\nSee full docs at https://github.com/sockeon/docs/blob/v2.0/getting-started/installation.md.\n",
        'core/controllers.md' => "# Controllers\n\nSee full docs at https://github.com/sockeon/docs/blob/v2.0/core/controllers.md.\n",
        'core/routing.md' => "# Routing\n\nSee full docs at https://github.com/sockeon/docs/blob/v2.0/core/routing.md.\n",
        'core/middleware.md' => "# Middleware\n\nSee full docs at https://github.com/sockeon/docs/blob/v2.0/core/middleware.md.\n",
        'core/namespaces-rooms.md' => "# Namespaces and Rooms\n\nSee full docs at https://github.com/sockeon/docs/blob/v2.0/core/namespaces-rooms.md.\n",
    ];

    /**
     * Canonical docs links on the GitHub docs repository.
     *
     * @return array<string, string>
     */
    public function links(): array
    {
        return [
            'installation' => self::DOCS_GITHUB_BASE . 'getting-started/installation.md',
            'quick-start' => self::DOCS_GITHUB_BASE . 'getting-started/quick-start.md',
            'controllers' => self::DOCS_GITHUB_BASE . 'core/controllers.md',
            'routing' => self::DOCS_GITHUB_BASE . 'core/routing.md',
            'middleware' => self::DOCS_GITHUB_BASE . 'core/middleware.md',
            'namespaces-rooms' => self::DOCS_GITHUB_BASE . 'core/namespaces-rooms.md',
            'server-configuration' => self::DOCS_GITHUB_BASE . 'core/server-configuration.md',
            'websocket-events' => self::DOCS_GITHUB_BASE . 'websocket/events.md',
            'websocket-connections' => self::DOCS_GITHUB_BASE . 'websocket/connections.md',
            'websocket-broadcasting' => self::DOCS_GITHUB_BASE . 'websocket/broadcasting.md',
            'websocket-client' => self::DOCS_GITHUB_BASE . 'websocket/client.md',
            'http-routing' => self::DOCS_GITHUB_BASE . 'http/routing.md',
            'request-response' => self::DOCS_GITHUB_BASE . 'http/request-response.md',
            'cors' => self::DOCS_GITHUB_BASE . 'http/cors.md',
            'validation' => self::DOCS_GITHUB_BASE . 'validation/validation.md',
            'sanitization' => self::DOCS_GITHUB_BASE . 'validation/sanitization.md',
            'rate-limiting' => self::DOCS_GITHUB_BASE . 'advanced/rate-limiting.md',
            'logging' => self::DOCS_GITHUB_BASE . 'advanced/logging.md',
            'error-handling' => self::DOCS_GITHUB_BASE . 'advanced/error-handling.md',
            'reverse-proxy' => self::DOCS_GITHUB_BASE . 'advanced/reverse-proxy-load-balancing.md',
            'basic-server-example' => self::DOCS_GITHUB_BASE . 'examples/basic-server.md',
            'http-server-example' => self::DOCS_GITHUB_BASE . 'examples/http-server.md',
        ];
    }

    public function linksAsMarkdown(): string
    {
        $lines = ["# Sockeon Docs Links", ''];

        foreach ($this->links() as $topic => $url) {
            $lines[] = "- {$topic}: {$url}";
        }

        return implode("\n", $lines) . "\n";
    }

    public function resolveTopicPath(string $category, string $topic): string
    {
        $topic = preg_replace('/(\.html|\.md)$/', '', $topic) ?? $topic;
        $key = strtolower(trim($category . '/' . $topic, '/'));

        return match ($key) {
            'advanced/reverse-proxy' => 'advanced/reverse-proxy-load-balancing.md',
            default => "{$category}/{$topic}.md",
        };
    }

    public function read(string $path): string
    {
        $normalizedPath = ltrim($path, '/');
        $url = self::BASE_URL . $normalizedPath;

        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: Sockeon-MCP-Server/2.0',
                    'Accept: text/markdown,text/plain,*/*',
                ],
                'timeout' => 10,
                'follow_location' => true,
            ],
        ]);

        $content = @file_get_contents($url, false, $context);
        if (is_string($content) && $content !== '') {
            return $content;
        }

        if (isset($this->fallbackDocs[$normalizedPath])) {
            return $this->fallbackDocs[$normalizedPath];
        }

        throw new RuntimeException("Failed to fetch documentation for: {$normalizedPath}");
    }
}
