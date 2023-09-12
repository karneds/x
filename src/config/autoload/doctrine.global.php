<?php

declare(strict_types=1);

use Doctrine\Common\Cache\PhpFileCache;
use Doctrine\DBAL\Driver\PDO\PgSQL\Driver;
use Doctrine\Migrations\Configuration\Migration\ConfigurationLoader;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Tools\Console\Command;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Ramsey\Uuid\Doctrine\UuidType;
use Roave\PsrContainerDoctrine\ConfigurationFactory;
use Roave\PsrContainerDoctrine\ConnectionFactory;
use Roave\PsrContainerDoctrine\EntityManagerFactory;
use Roave\PsrContainerDoctrine\EventManagerFactory;
use Roave\PsrContainerDoctrine\Migrations\CommandFactory;
use Roave\PsrContainerDoctrine\Migrations\ConfigurationLoaderFactory;
use Roave\PsrContainerDoctrine\Migrations\DependencyFactoryFactory;

return [
    'doctrine' => [
        'connection'    => [
            'orm_default' => [
                'params'       => [
                    'dbname'   => getenv('DB_NAME'),
                    'user'     => getenv('DB_USER'),
                    'password' => getenv('DB_PASS'),
                    'host'     => 'postgres',
                    'charset'  => 'utf8',
                ],
                'driver_class' => Driver::class,
            ],
        ],
        'event_manager' => [
        ],
        'driver'        => [
            'orm_default' => [
                'class'   => MappingDriverChain::class,
                'cache'   => 'files',
                'paths'   => [],
                'drivers' => [],
            ],
            'xml'         => [
                'class' => SimplifiedXmlDriver::class,
                'cache' => 'files',
                'paths' => [],
            ],
            'attribute'   => [
                'class' => AttributeDriver::class,
                'cache' => 'files',
                'paths' => [],
            ],
            'annotation'  => [
                'class' => AnnotationDriver::class,
                'cache' => 'files',
                'paths' => [],
            ],
        ],
        'configuration' => [
            'orm_default' => [
                'proxy_dir'                   => 'data/doctrine/proxy',
                'auto_generate_proxy_classes' => false,
                'query_cache'                 => 'files',
                'metadata_cache'              => 'files',
                'result_cache'                => 'files',
            ],
        ],
        'migrations'    => [
            'orm_default' => [
                'table_storage'    => [
                    'table_name' => 'migrations',
                ],
                'migrations_paths' => [],
            ],
        ],
        'cache'         => [
            'files' => [
                'class'     => PhpFileCache::class,
                'directory' => getcwd() . '/data/cache/doctrine',
            ],
        ],
        'types'         => [
            UuidType::NAME            => UuidType::class
        ],
    ],
    'dependencies' => [
        'aliases'            => [
            EntityManagerInterface::class => 'doctrine.entity_manager.orm_default',
        ],
        'delegators'         => [],
        'invokables'         => [],
        'factories'          => [
            'doctrine.entity_manager.orm_default' => EntityManagerFactory::class,
            'doctrine.connection.orm_default'     => ConnectionFactory::class,
            'doctrine.event_manager.orm_default'  => EventManagerFactory::class,
            'doctrine.migrations.orm_default'     => ConfigurationLoaderFactory::class,
            'doctrine.configuration.orm_default'  => ConfigurationFactory::class,
            Command\DiffCommand::class            => CommandFactory::class,
            Command\DumpSchemaCommand::class      => CommandFactory::class,
            Command\ExecuteCommand::class         => CommandFactory::class,
            Command\GenerateCommand::class        => CommandFactory::class,
            Command\LatestCommand::class          => CommandFactory::class,
            Command\MigrateCommand::class         => CommandFactory::class,
            Command\RollupCommand::class          => CommandFactory::class,
            Command\StatusCommand::class          => CommandFactory::class,
            Command\UpToDateCommand::class        => CommandFactory::class,
            Command\VersionCommand::class         => CommandFactory::class,
            ConfigurationLoader::class            => ConfigurationLoaderFactory::class,
            DependencyFactory::class              => DependencyFactoryFactory::class,
        ],
    ],
    'laminas-cli' => [
        'commands' => [
            'migration:generate' => Command\GenerateCommand::class,
            'migration:up'       => Command\MigrateCommand::class,
            'migration:execute'  => Command\ExecuteCommand::class,
            'migration:down'     => Command\RollupCommand::class,
            'migration:status'   => Command\StatusCommand::class,
        ]
    ]
];