<?php

declare(strict_types=1);

namespace App\Application\Handlers;

use App\Application\Actions\ViewsTrait;
use App\Domain\LTI\LaunchDataRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\UsersTrait;
use GrotonSchool\Slim\LTI\Handlers\LaunchHandlerInterface;
use Packback\Lti1p3\LtiConstants;
use Packback\Lti1p3\LtiMessageLaunch;
use Psr\Http\Message\ResponseInterface;

class LaunchHandler implements LaunchHandlerInterface
{
    use ViewsTrait;
    use UsersTrait;

    public function __construct(
        LaunchDataRepositoryInterface $launchData,
        UserRepositoryInterface $users
    ) {
        $this->initUsers($launchData, $users);
        $this->initViews();
    }

    public function handle(
        ResponseInterface $response,
        LtiMessageLaunch $launch
    ): ResponseInterface {
        /*
        * TODO actual handling of the LTI launch request goes here!
        */
        $data = $launch->getLaunchData();
        return $this->views->render($response, 'launchData.php', [
            'messageType' => $data[LtiConstants::MESSAGE_TYPE],
            'launchData' => $data
        ]);
    }
}
