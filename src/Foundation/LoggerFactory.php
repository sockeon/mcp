<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Foundation;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Stringable;

final class LoggerFactory
{
    public static function create(bool $debug = false, bool $fileLog = false): LoggerInterface
    {
        return new class ($debug, $fileLog) extends AbstractLogger {
            public function __construct(
                private readonly bool $debug,
                private readonly bool $fileLog
            ) {
            }

            public function log($level, Stringable|string $message, array $context = []): void
            {
                if (!$this->debug && 'debug' === $level) {
                    return;
                }

                $logMessage = sprintf(
                    "[%s] %s %s\n",
                    strtoupper((string) $level),
                    (string) $message,
                    ($context === [] || !$this->debug) ? '' : json_encode($context),
                );

                if ($this->fileLog || !defined('STDERR')) {
                    file_put_contents('dev.log', $logMessage, FILE_APPEND);
                    return;
                }

                fwrite(STDERR, $logMessage);
            }
        };
    }
}
