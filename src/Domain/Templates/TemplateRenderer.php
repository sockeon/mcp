<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Domain\Templates;

use RuntimeException;

final class TemplateRenderer
{
    public function __construct(
        private readonly string $stubsPath = __DIR__ . '/../../../stubs'
    ) {
    }

    public function render(string $stubPath, array $replacements = []): string
    {
        $fullPath = $this->stubsPath . '/' . ltrim($stubPath, '/');

        if (!is_file($fullPath)) {
            throw new RuntimeException("Stub file not found: {$fullPath}");
        }

        $content = file_get_contents($fullPath);

        foreach ($replacements as $key => $value) {
            $content = str_replace('{{' . $key . '}}', (string) $value, $content);
        }

        return $content;
    }
}
