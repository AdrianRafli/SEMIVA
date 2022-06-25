<?php

namespace Adrian\Website\Semiva\Middleware {

    require_once __DIR__ . '/../Helper/helper.php';

    use PHPUnit\Framework\TestCase;
    use Adrian\Website\Semiva\Config\Database;
    use Adrian\Website\Semiva\Domain\Session;
    use Adrian\Website\Semiva\Domain\User;
    use Adrian\Website\Semiva\Repository\SessionRepository;
    use Adrian\Website\Semiva\Repository\UserRepository;
    use Adrian\Website\Semiva\Service\SessionService;

    class MustNotLoginMiddlewareTest extends TestCase
    {

        private MustNotLoginMiddleware $middleware;
        private UserRepository $userRepository;
        private SessionRepository $sessionRepository;

        protected function setUp():void
        {
            $this->middleware = new MustNotLoginMiddleware();
            putenv("mode=test");

            $this->userRepository = new UserRepository(Database::getConnection());
            $this->sessionRepository = new SessionRepository(Database::getConnection());

            $this->sessionRepository->deleteAll();
            $this->userRepository->deleteAll();
        }

        public function testBeforeGuest()
        {
            $this->middleware->before();
            $this->expectOutputString("");
        }

        public function testBeforeLoginUser()
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

            $this->middleware->before();
            $this->expectOutputRegex("[Location: /]");

        }

    }
}


