<?php

namespace Sockeon\Mcp\Helpers;

use RuntimeException;

class StubLoader
{
    private string $stubsPath;

    public function __construct(?string $stubsPath = null)
    {
        $this->stubsPath = $stubsPath ?? __DIR__ . '/../stubs';
    }

    public function load(string $stubPath, array $replacements = []): string
    {
        $fullPath = $this->stubsPath . '/' . $stubPath;
        
        if (!file_exists($fullPath)) {
            throw new RuntimeException("Stub file not found: {$fullPath}");
        }

        $content = file_get_contents($fullPath);

        foreach ($replacements as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }

        return $content;
    }

    public function getStubsPath(): string
    {
        return $this->stubsPath;
    }
}

