<?php

declare(strict_types=1);

namespace News\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use News\Contract\NewsServiceInterface;
use News\NewsService;
use Psr\Container\ContainerInterface;

class NewsServiceFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): NewsServiceInterface {
        return new NewsService(
            $container->get(EntityManagerInterface::class)
        );
    }
}
