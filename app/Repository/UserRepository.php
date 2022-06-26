<?php

namespace Adrian\Website\Semiva\Repository;

use Adrian\Website\Semiva\Domain\User;

class UserRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user): User
    {
        
        $statement = $this->connection->prepare("INSERT INTO users(email, username, password) VALUES (?, ?, ?)");
        $getId = $this->connection->lastInsertId();
        $user->id = $getId;
        $statement->execute([
            $user->email, $user->username, $user->password
        ]);
        
        return $user;
    }

    public function update(User $user): User
    {
        $statement = $this->connection->prepare("UPDATE users SET email= ?, username = ?, password = ? WHERE id = ?");
        $statement->execute([
            $user->email, $user->username, $user->password, $user->id
        ]);
        return $user;
    }

    public function findById(string $id): ?User
    {
        $statement = $this->connection->prepare("SELECT id, email, username, password FROM users WHERE id = ?");
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $user = new User();
                $user->id = $row['id'];
                $user->email = $row['email'];
                $user->username = $row['username'];
                $user->password = $row['password'];
                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE from users");
    }
}