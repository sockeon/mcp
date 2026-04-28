<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Workflows;

final class WorkflowRunner
{
    /**
     * @param array<int, array<string, mixed>> $steps
     * @return array<int, array<string, mixed>>
     */
    public function run(array $steps): array
    {
        $normalized = [];

        foreach ($steps as $index => $step) {
            $normalized[] = [
                'id' => $step['id'] ?? 'step_' . ($index + 1),
                'title' => $step['title'] ?? ('Step ' . ($index + 1)),
                'tool' => $step['tool'] ?? null,
                'args' => $step['args'] ?? [],
                'phase' => $step['phase'] ?? 'default',
            ];
        }

        return $normalized;
    }
}
