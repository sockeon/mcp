<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Foundation;

use Mcp\Capability\Registry\Container;
use Sockeon\Mcp\Domain\Generation\CodeGenerator;
use Psr\Log\LoggerInterface;
use Sockeon\Mcp\Domain\Docs\DocsRepository;
use Sockeon\Mcp\Domain\Templates\TemplateRenderer;
use Sockeon\Mcp\Domain\Validation\ValidationRulesCatalog;

final class ContainerFactory
{
    public static function create(LoggerInterface $logger): Container
    {
        $container = new Container();
        $container->set(LoggerInterface::class, $logger);
        $renderer = new TemplateRenderer();
        $container->set(TemplateRenderer::class, $renderer);
        $container->set(CodeGenerator::class, new CodeGenerator($renderer));
        $container->set(DocsRepository::class, new DocsRepository());
        $container->set(ValidationRulesCatalog::class, new ValidationRulesCatalog());

        return $container;
    }
}
