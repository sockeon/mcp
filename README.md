# Sockeon MCP Server

Sockeon MCP provides a modular application kernel with guided workflows and focused tool packs for Sockeon development.

## Architecture

The new server is split by responsibility:

- `src/Foundation`: app boot, logger, container, and server factory.
- `src/Domain`: reusable services (`CodeGenerator`, `TemplateRenderer`, `DocsRepository`, `ValidationRulesCatalog`).
- `src/Capabilities/Tools`: domain tools (`Scaffold`, `Config`, `Realtime`, `Security`, `Observability`).
- `src/Capabilities/Resources`: docs, stubs, and validation resources.
- `src/Capabilities/Prompts`: workflow-oriented guided prompts.
- `src/Workflows`: orchestration primitives for high-level guided flows.

Only `src/Capabilities` is discovered by MCP runtime.

## Installation

```bash
cd mcp
composer install
```

Run the MCP server:

```bash
php public/server.php
```

## MCP Capability Model

### Tools (modular)

- `sockeon_scaffold_server`
- `sockeon_scaffold_controller`
- `sockeon_scaffold_example`
- `sockeon_config_server`
- `sockeon_config_rate_limit`
- `sockeon_config_cors`
- `sockeon_config_reverse_proxy`
- `sockeon_realtime_websocket_handler`
- `sockeon_realtime_http_route`
- `sockeon_realtime_room_management`
- `sockeon_realtime_namespace_management`
- `sockeon_security_validation_rules`
- `sockeon_security_middleware`
- `sockeon_security_authentication`
- `sockeon_observability_error_handler`
- `sockeon_observability_logging_setup`

### Resources

- `sockeon://docs/quick-start`
- `sockeon://docs/controllers`
- `sockeon://docs/{category}/{topic}`
- `sockeon://stubs/{type}/{name}`
- `sockeon://validation/rules`

### Workflow Prompts

- `sockeon_workflow_scaffold_realtime_app`
- `sockeon_workflow_harden_production_server`

## Development

### Tests

```bash
composer test
```

### Add New Tool Pack

1. Create a class under `src/Capabilities/Tools/<Domain>/`.
2. Annotate methods with `#[McpTool(...)]`.
3. Keep generation/business logic in `src/Domain` services (`CodeGenerator` first, then focused helpers).
4. Add unit tests in `tests/Unit`.

## Notes

- Documentation resources use a remote-first strategy with local fallback text for key pages.
