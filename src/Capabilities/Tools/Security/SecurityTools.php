<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Capabilities\Tools\Security;

use Mcp\Capability\Attribute\McpTool;
use Sockeon\Mcp\Domain\Generation\CodeGenerator;
use Sockeon\Mcp\Domain\Validation\ValidationRulesCatalog;

final class SecurityTools
{
    public function __construct(
        private readonly CodeGenerator $generator = new CodeGenerator(),
        private readonly ValidationRulesCatalog $rules = new ValidationRulesCatalog(),
    ) {
    }

    #[McpTool(
        name: 'sockeon_security_validation_rules',
        description: 'List all Sockeon validation rules and descriptions',
    )]
    public function listValidationRules(): array
    {
        return $this->rules->all();
    }

    #[McpTool(
        name: 'sockeon_security_middleware',
        description: 'Generate middleware class for http, websocket, or handshake context',
    )]
    public function generateMiddleware(
        string $middlewareName,
        string $type = 'http',
    ): string {
        return $this->generator->middleware($middlewareName, $type);
    }

    #[McpTool(
        name: 'sockeon_security_authentication',
        description: 'Generate authentication middleware using key or token flow',
    )]
    public function generateAuthentication(string $authType = 'key'): string
    {
        return $this->generator->authentication($authType);
    }

    #[McpTool(
        name: 'sockeon_security_validation_example',
        description: 'Generate validation snippet for websocket handlers using framework validator',
    )]
    public function generateValidationExample(): string
    {
        return $this->generator->validationExample();
    }
}
