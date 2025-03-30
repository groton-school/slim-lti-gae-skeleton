<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Google\Cloud\Logging\LoggingClient;
use GrotonSchool\Slim\GAE;
use GrotonSchool\Slim\LTI;
use GrotonSchool\Slim\LTI\Infrastructure;
use GrotonSchool\Slim\LTI\Infrastructure\Cookie;
use GrotonSchool\Slim\LTI\Infrastructure\DatabaseInterface;
use GrotonSchool\Slim\LTI\Infrastructure\GAE\Cache;
use GrotonSchool\Slim\LTI\Infrastructure\GAE\Database;
use Packback\Lti1p3\Interfaces\ICache;
use Packback\Lti1p3\Interfaces\ICookie;
use Packback\Lti1p3\Interfaces\IDatabase;
use Packback\Lti1p3\Interfaces\ILtiServiceConnector;
use Packback\Lti1p3\LtiServiceConnector;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            /** @var SettingsInterface $settings */
            $settings = $c->get(SettingsInterface::class);
            $client = new LoggingClient([
                'projectId' => $settings->getProjectId()
            ]);
            $logger = $client->psrBatchLogger('slim-gae-skeleton');
            return $logger;
        },
        // all settings interfaces map to the App Settings
        GAE\SettingsInterface::class => DI\get(SettingsInterface::class),
        LTI\SettingsInterface::class => DI\get(SettingsInterface::class),
        Infrastructure\GAE\SettingsInterface::class => DI\get(SettingsInterface::class),

        // autowire interface implementations
        ILtiServiceConnector::class => DI\autowire(LtiServiceConnector::class),
        ICookie::class => DI\autowire(Cookie::class),
        ICache::class => DI\autowire(Cache::class),
        IDatabase::class => DI\autowire(Database::class),
        DatabaseInterface::class => DI\autowire(Database::class),
]);
};
