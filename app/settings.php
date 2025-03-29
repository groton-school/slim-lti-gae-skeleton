<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,

                // get Google Cloud Project ID and URL from local environment
                Settings::PROJECT_ID => getenv('PROJECT'),
                Settings::PROJECT_URL => getenv('PROJECT_URL')
            ]);
        }
    ]);
};
