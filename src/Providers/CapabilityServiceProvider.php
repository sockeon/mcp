<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Providers;

final class CapabilityServiceProvider
{
    /**
     * @return array<int, string>
     */
    public function capabilityNamespaces(): array
    {
        return [
            'Sockeon\\Mcp\\Capabilities\\Tools',
            'Sockeon\\Mcp\\Capabilities\\Resources',
            'Sockeon\\Mcp\\Capabilities\\Prompts',
        ];
    }
}
