<?php

namespace Adrian\Website\Semiva\Controller;

use Adrian\Website\Semiva\App\View;
use Adrian\Website\Semiva\Config\Database;
use Adrian\Website\Semiva\Repository\SessionRepository;
use Adrian\Website\Semiva\Repository\UserRepository;
use Adrian\Website\Semiva\Service\SessionService;

class HomeController
{

    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }


    function index()
    {
        $user = $this->sessionService->current();
        if ($user == null) {
            View::render('Home/index', [
                "title" => "PHP Login Management"
            ]);
        } else {
            View::render('Home/dashboard', [
                "title" => "Dashboard",
                "user" => [
                    "name" => $user->name
                ]
            ]);
        }
    }

}