<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Google\Cloud\Logging\LoggingClient;
use GrotonSchool\Slim\GAE;;
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
        GAE\SettingsInterface::class => DI\get(SettingsInterface::class)
    ]);
};
