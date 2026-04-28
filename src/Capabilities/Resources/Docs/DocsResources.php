<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Capabilities\Resources\Docs;

use Mcp\Capability\Attribute\McpResource;
use Mcp\Capability\Attribute\CompletionProvider;
use Mcp\Capability\Attribute\McpResourceTemplate;
use Sockeon\Mcp\Domain\Docs\DocsRepository;

final class DocsResources
{
    public function __construct(
        private readonly DocsRepository $docs = new DocsRepository()
    ) {
    }

    #[McpResource(
        uri: 'sockeon://docs/quick-start',
        name: 'Sockeon-Quick-Start',
        description: 'Quick start guide for Sockeon framework',
        mimeType: 'text/markdown'
    )]
    public function quickStart(): string
    {
        return $this->docs->read('getting-started/quick-start.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/controllers',
        name: 'Sockeon-Controllers-Guide',
        description: 'Controller guide for Sockeon framework',
        mimeType: 'text/markdown'
    )]
    public function controllers(): string
    {
        return $this->docs->read('core/controllers.md');
    }

    #[McpResource(
        uri: 'sockeon://docs/links',
        name: 'Sockeon-Docs-Links',
        description: 'Canonical Sockeon docs links from GitHub repository',
        mimeType: 'text/markdown'
    )]
    public function links(): string
    {
        return $this->docs->linksAsMarkdown();
    }

    #[McpResourceTemplate(
        uriTemplate: 'sockeon://docs/{category}/{topic}',
        name: 'Sockeon-Docs-Topic',
        description: 'Fetch docs by category and topic',
        mimeType: 'text/markdown'
    )]
    public function topic(
        #[CompletionProvider(values: ['getting-started', 'core', 'websocket', 'http', 'validation', 'advanced', 'examples'])]
        string $category,
        #[CompletionProvider(values: [
            'installation',
            'quick-start',
            'basic-concepts',
            'controllers',
            'routing',
            'middleware',
            'namespaces-rooms',
            'server-configuration',
            'events',
            'connections',
            'broadcasting',
            'client',
            'request-response',
            'cors',
            'validation',
            'sanitization',
            'rate-limiting',
            'logging',
            'error-handling',
            'reverse-proxy',
            'reverse-proxy-load-balancing',
            'basic-server',
            'http-server',
            'hybrid-server',
            'basic-client',
        ])]
        string $topic
    ): string
    {
        return $this->docs->read($this->docs->resolveTopicPath($category, $topic));
    }
}
