<?php

namespace Adrian\Website\Semiva\Middleware;

class AuthMiddleware implements Middleware
{

    function before(): void
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }
    }
}