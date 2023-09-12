<?php

declare(strict_types=1);

namespace News;
use Mezzio\Application;
use News\Contract\NewsServiceInterface;

/**
 * The configuration provider for the News module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'doctrine'    => $this->getDoctrine(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
            ],
            'delegators' => [
                Application::class => [
                    RoutesDelegator::class,
                ],
            ],
            'factories'  => [
                NewsServiceInterface::class => Factory\NewsServiceFactory::class
            ],
            
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getDoctrine() : array
    {
        return [
            'driver'     => [
                'attribute'   => [
                    'paths' => [
                        __DIR__ . '/Entity',
                    ],
                ],
                'orm_default' => [
                    'drivers' => [
                        'News\Entity' => 'attribute',
                    ],
                ],
            ],
            'migrations' => [
                'orm_default' => [
                    'migrations_paths' => [
                        'News\Migrations' => __DIR__ . '/../migrations',
                    ],
                ],
            ],
        ];
    }
}
