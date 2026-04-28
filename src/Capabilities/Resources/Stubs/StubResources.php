<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Capabilities\Resources\Stubs;

use Mcp\Capability\Attribute\McpResourceTemplate;
use Sockeon\Mcp\Domain\Templates\TemplateRenderer;

final class StubResources
{
    public function __construct(
        private readonly TemplateRenderer $templates = new TemplateRenderer()
    ) {
    }

    #[McpResourceTemplate(
        uriTemplate: 'sockeon://stubs/{type}/{name}',
        name: 'Sockeon-Stub',
        description: 'Fetch Sockeon code generation stub',
        mimeType: 'text/x-php'
    )]
    public function stub(string $type, string $name): string
    {
        return $this->templates->render("{$type}/{$name}.php.stub");
    }
}
