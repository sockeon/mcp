<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Capabilities\Resources\Validation;

use Mcp\Capability\Attribute\McpResource;
use Sockeon\Mcp\Domain\Validation\ValidationRulesCatalog;

final class ValidationResources
{
    public function __construct(
        private readonly ValidationRulesCatalog $rules = new ValidationRulesCatalog()
    ) {
    }

    #[McpResource(
        uri: 'sockeon://validation/rules',
        name: 'Sockeon-Validation-Rules',
        description: 'List all validation rules available in Sockeon',
        mimeType: 'application/json'
    )]
    public function rules(): array
    {
        return $this->rules->all();
    }
}
