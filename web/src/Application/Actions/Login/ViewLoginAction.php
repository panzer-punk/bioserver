<?php

declare(strict_types=1);

namespace App\Application\Actions\Login;

use App\Application\Actions\Action;
use App\Application\Settings\SettingsInterface;
use App\Domain\Login\PasswordValidatorInterface;
use App\Domain\Login\UserNameValidatorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\Twig;

final class ViewLoginAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        private SettingsInterface $settings,
        private PasswordValidatorInterface $passwordValidator,
        private UserNameValidatorInterface $usernameValidator
    ) {
        parent::__construct($logger);
    }

    protected function action(): ResponseInterface
    {
        $settings = $this->settings;
        $twig     = Twig::fromRequest($this->request);

        $title = sprintf(
            "%s: %s server",
            $settings->get("version"),
            $settings->get("production") ? "production" : "non production"
        );
        $gameID = $this->resolveArg("gameID");

        return $twig->render(
                $this->response,
                "login.html.twig",
                [
                    "title" => $title,
                    "passwordCriteria" => $this->passwordValidator->criteria(),
                    "usernameCriteria" => $this->usernameValidator->criteria(),
                    "gameID" => $gameID
                ]
        );
    }
}
