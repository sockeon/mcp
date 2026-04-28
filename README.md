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

- `sockeon.scaffold.server`
- `sockeon.scaffold.controller`
- `sockeon.scaffold.example`
- `sockeon.config.server`
- `sockeon.config.rate_limit`
- `sockeon.config.cors`
- `sockeon.config.reverse_proxy`
- `sockeon.realtime.websocket_handler`
- `sockeon.realtime.http_route`
- `sockeon.realtime.room_management`
- `sockeon.realtime.namespace_management`
- `sockeon.security.validation_rules`
- `sockeon.security.middleware`
- `sockeon.security.authentication`
- `sockeon.observability.error_handler`
- `sockeon.observability.logging_setup`

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
