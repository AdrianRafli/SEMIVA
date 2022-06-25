<?php

namespace Adrian\Website\Semiva\Middleware;

use Adrian\Website\Semiva\App\View;
use Adrian\Website\Semiva\Config\Database;
use Adrian\Website\Semiva\Repository\SessionRepository;
use Adrian\Website\Semiva\Repository\UserRepository;
use Adrian\Website\Semiva\Service\SessionService;

class MustLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    function before(): void
    {
        $user = $this->sessionService->current();
        if ($user == null) {
            View::redirect('/users/login');
        }
    }
}