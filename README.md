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

Configure the Sockeon MCP server for your preferred client:

#### Claude Desktop

1. **Locate the configuration file:**
   - **macOS**: `~/Library/Application Support/Claude/claude_desktop_config.json`
   - **Windows**: `%APPDATA%\Claude\claude_desktop_config.json`
   - **Linux**: `~/.config/Claude/claude_desktop_config.json`

2. **Open or create the file** and add the Sockeon MCP server:

```json
{
  "mcpServers": {
    "sockeon": {
      "command": "php",
      "args": ["/absolute/path/to/mcp/public/server.php"]
    }
  }
}
```

3. **Replace the path** with the absolute path to your `server.php` file.

4. **Restart Claude Desktop** to apply the changes.

**Example paths:**
- macOS: `"/Users/username/Projects/mcp/public/server.php"`
- Windows: `"C:\\Users\\username\\Projects\\mcp\\public\\server.php"`
- Linux: `"/home/username/Projects/mcp/public/server.php"`

#### Cursor

1. **Open Cursor Settings:**
   - Press `Cmd+,` (macOS) or `Ctrl+,` (Windows/Linux)
   - Or go to `File` > `Preferences` > `Settings`

2. **Search for "MCP"** or navigate to `Features` > `Model Context Protocol`

3. **Add MCP Server Configuration:**
   - Click `Edit Config` or manually edit the MCP configuration file
   - The configuration file is typically located at:
     - **macOS**: `~/Library/Application Support/Cursor/User/globalStorage/mcp.json`
     - **Windows**: `%APPDATA%\Cursor\User\globalStorage\mcp.json`
     - **Linux**: `~/.config/Cursor/User/globalStorage/mcp.json`

4. **Add the Sockeon server configuration:**

```json
{
  "mcpServers": {
    "sockeon": {
      "command": "php",
      "args": ["/absolute/path/to/mcp/public/server.php"]
    }
  }
}
```

5. **Replace the path** with the absolute path to your `server.php` file.

6. **Restart Cursor** to apply the changes.

#### Visual Studio Code

1. **Install the MCP Extension:**
   - Open VS Code Extensions (`Cmd+Shift+X` or `Ctrl+Shift+X`)
   - Search for "Model Context Protocol" or "MCP"
   - Install the official MCP extension

2. **Configure MCP Server:**
   - Open VS Code Settings (`Cmd+,` or `Ctrl+,`)
   - Search for "MCP" settings
   - Or create/edit `.vscode/settings.json` in your workspace:

```json
{
  "mcp.servers": {
    "sockeon": {
      "command": "php",
      "args": ["${workspaceFolder}/mcp/public/server.php"]
    }
  }
}
```

3. **For global configuration**, add to your User Settings:

```json
{
  "mcp.servers": {
    "sockeon": {
      "command": "php",
      "args": ["/absolute/path/to/mcp/public/server.php"]
    }
  }
}
```

4. **Reload VS Code** to apply the changes.

**Note:** If using a workspace-relative path, `${workspaceFolder}` will be replaced with your workspace root. For global settings, use an absolute path.

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
