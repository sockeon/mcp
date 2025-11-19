# Sockeon MCP Server

Model Context Protocol (MCP) server for the Sockeon framework. This MCP server provides comprehensive tools, resources, and prompts to help developers work with Sockeon, including code generation, configuration helpers, and real-time documentation access.

## About

The Sockeon MCP Server is an MCP-compliant server that integrates with AI assistants (like Claude Desktop) to provide intelligent assistance when working with the Sockeon framework. It offers:

- **Code Generation**: Generate servers, controllers, handlers, middleware, and complete examples
- **Documentation Access**: Real-time access to Sockeon documentation from the official website
- **Configuration Helpers**: Generate configuration files for CORS, rate limiting, authentication, and more
- **Validation Tools**: Access validation rules and generate validation code
- **Example Templates**: Pre-built examples for common use cases (chat, game, API, notifications)

All code generation uses template-based stubs for easy maintenance and customization. Documentation is fetched in real-time from the official Sockeon website to ensure you always have the latest information.

## Installation

### Prerequisites

- PHP 8.1 or higher
- Composer

### Steps

1. **Install dependencies:**

```bash
cd mcp
composer install
```

2. **Make the server executable:**

```bash
chmod +x public/server.php
```

3. **Verify installation:**

```bash
php public/server.php
```

The server should start without errors. Press `Ctrl+C` to stop it.

## Configuration

### MCP Client Configuration

To use this MCP server with an MCP client (like Claude Desktop), add it to your MCP configuration file:

**For Claude Desktop** (`~/Library/Application Support/Claude/claude_desktop_config.json` on macOS, or `%APPDATA%\Claude\claude_desktop_config.json` on Windows):

```json
{
  "mcpServers": {
    "sockeon": {
      "command": "php",
      "args": ["/absolute/path/to/sockeon/framework/mcp/public/server.php"]
    }
  }
}
```

**For other MCP clients**, refer to their documentation for configuration format.

### Environment Variables

The server supports the following environment variables:

- `DEBUG=true` - Enable debug logging (default: false)
- `FILE_LOG=true` - Log to file instead of stderr (default: false)

## Usage

Once configured, your AI assistant can:

- Generate Sockeon server code and configurations
- Access Sockeon documentation and examples
- Create controllers, handlers, and middleware
- Set up authentication, rate limiting, and CORS
- Generate complete application examples
- Access validation rules and generate validation code

Simply ask your AI assistant to help with Sockeon development, and it will use the available tools and resources automatically.

## Development

### Adding New Capabilities

The MCP server uses attribute-based discovery. To add new capabilities:

**Adding a Tool:**

```php
#[McpTool(
    name: 'my_new_tool',
    description: 'Description of what the tool does',
)]
public function myNewTool(string $param): string
{
    // Tool implementation
    return "Result";
}
```

**Adding a Resource:**

```php
#[McpResource(
    uri: 'sockeon://my-resource',
    name: 'My-Resource',
    description: 'Description of the resource',
    mimeType: 'text/plain'
)]
public function getMyResource(): string
{
    return "Resource content";
}
```

**Adding a Prompt:**

```php
#[McpPrompt(
    name: 'my_prompt',
    description: 'Description of the prompt workflow'
)]
public function myPrompt(): string
{
    return "Prompt template content";
}
```

The MCP SDK will automatically discover and register all capabilities.

### Stub Files

All code generation uses stub files located in the `stubs/` directory. Stub files use `{{{PLACEHOLDER}}}` syntax for variable replacement. To modify generated code, edit the corresponding stub file.

## Features

- **Comprehensive Coverage**: Supports all Sockeon features including WebSocket, HTTP, middleware, validation, rate limiting, CORS, authentication, logging, error handling, namespaces, and rooms
- **Real-time Documentation**: Documentation resources fetch content from [https://sockeon.com](https://sockeon.com) in real-time
- **Template-based Generation**: All code generation uses separate stub files for easy maintenance and customization
- **Version-aware**: Documentation fetching supports versioning via GitHub raw URLs

## License

MIT License - see the main Sockeon LICENSE file for details.

## Links

- [Sockeon Framework](https://github.com/sockeon/sockeon)
- [Sockeon Documentation](https://sockeon.com)
- [Model Context Protocol](https://modelcontextprotocol.io)
- [MCP PHP SDK](https://github.com/modelcontextprotocol/php-sdk)
