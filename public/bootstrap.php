<?php

use Http\Discovery\Psr17Factory;
use Mcp\Capability\Registry\Container;
use Mcp\Server\Transport\StdioTransport;
use Mcp\Server\Transport\StreamableHttpTransport;
use Mcp\Server\Transport\TransportInterface;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

function container(): Container
{
    $container = new Container();
    $container->set(LoggerInterface::class, logger());

    return $container;
}

function transport(): TransportInterface
{
    if ('cli' === PHP_SAPI) {
        return new StdioTransport(logger: logger());
    }

    return new StreamableHttpTransport(
        (new Psr17Factory())->createServerRequestFromGlobals(),
        logger: logger(),
    );
}

function logger(): LoggerInterface
{
    return new class extends AbstractLogger {
        public function log($level, Stringable|string $message, array $context = []): void
        {
            $debug = $_SERVER['DEBUG'] ?? false;

            if (!$debug && 'debug' === $level) {
                return;
            }

            $logMessage = sprintf(
                "[%s] %s %s\n",
                strtoupper($level),
                $message,
                ([] === $context || !$debug) ? '' : json_encode($context),
            );

            if (($_SERVER['FILE_LOG'] ?? false) || !defined('STDERR')) {
                file_put_contents('dev.log', $logMessage, FILE_APPEND);
            } else {
                fwrite(STDERR, $logMessage);
            }
        }
    };
}
