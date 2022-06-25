<?php

namespace Adrian\Website\Semiva\Controller;

use PHPUnit\Framework\TestCase;
use Adrian\Website\Semiva\Config\Database;
use Adrian\Website\Semiva\Domain\Session;
use Adrian\Website\Semiva\Domain\User;
use Adrian\Website\Semiva\Repository\SessionRepository;
use Adrian\Website\Semiva\Repository\UserRepository;
use Adrian\Website\Semiva\Service\SessionService;

class HomeControllerTest extends TestCase
{
    private HomeController $homeController;
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    protected function setUp():void
    {
        $this->homeController = new HomeController();
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testGuest()
    {
        $this->homeController->index();

        $this->expectOutputRegex("[Login Management]");
    }

    public function testUserLogin()
    {
        $user = new User();
        $user->id = "adrian";
        $user->name = "Adrian";
        $user->password = "rahasia";
        $this->userRepository->save($user);

        $session = new Session();
        $session->id = uniqid();
        $session->userId = $user->id;
        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $this->homeController->index();

        $this->expectOutputRegex("[Hello Adrian]");
    }

}
