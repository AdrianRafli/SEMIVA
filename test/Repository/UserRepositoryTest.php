<?php

namespace Adrian\Website\Semiva\Repository;

use PHPUnit\Framework\TestCase;
use Adrian\Website\Semiva\Config\Database;
use Adrian\Website\Semiva\Domain\User;

class UserRepositoryTest extends TestCase
{

    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    protected function setUp(): void
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->sessionRepository->deleteAll();

        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }

    public function testSaveSuccess()
    {
        $user = new User();
        $user->id = 
        $user->email = "adrianrafly@gmail.com";
        $user->username = "Adrian";
        $user->password = "rahasia";

        $this->userRepository->save($user);

        $result = $this->userRepository->findById($user->id);

        self::assertEquals($user->email, $result->email);
        self::assertEquals($user->username, $result->username);
        self::assertEquals($user->password, $result->password);
    }

    public function testFindByIdNotFound()
    {
        $user = $this->userRepository->findById("notfound");
        self::assertNull($user);
    }

    public function testUpdate()
    {
        $user = new User();
        $user->email = "adrianrafly@gmail.com";
        $user->username = "Adrian";
        $user->password = "rahasia";

        $this->userRepository->save($user);

        $user->username = "Budi";
        $this->userRepository->update($user);

        $result = $this->userRepository->findById($user->id);

        self::assertEquals($user->email, $result->email);
        self::assertEquals($user->username, $result->username);
        self::assertEquals($user->password, $result->password);
    }


}
