<?php

declare(strict_types=1);

namespace News;

use Mezzio\Application;
use Mezzio\Authentication\AuthenticationMiddleware;
use Psr\Container\ContainerInterface;

/**
 * Routes specific to the Notification module
 */
class RoutesDelegator
{
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /** @var Application $app */
        $app = $callback();

        $app->get('/news', [
            Handler\ListHandler::class,
        ]);

        $app->post('/news', [
            Handler\CreateHandler::class,
        ]);

        $app->put('/news/{id}', [
            Handler\UpdateHandler::class,
        ]);

        $app->delete('/news/{id}', [
            Handler\DeleteHandler::class,
        ]);

        return $app;
    }
}
