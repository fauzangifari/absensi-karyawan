<?php

namespace App\Repository;

use App\Domain\Session;

class SessionRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function saveSesion(Session $session): Session
    {
        $statement = $this->connection->prepare('INSERT INTO sessions(id_session, username) VALUES(?, ?)');
        $statement->execute([
            $session->id_session,
            $session->username
        ]);
        return $session;
    }

    public function findById(string $id): ?Session
    {
        $statement = $this->connection->prepare('SELECT * FROM sessions WHERE id_session = ?');
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()){
                $session = new Session();
                $session->id_session = $row['id_session'];
                $session->username = $row['username'];
                return $session;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteById(string $id): void
    {
        $statement = $this->connection->prepare('DELETE FROM sessions WHERE id_session = ?');
        $statement->execute([$id]);
    }

    public function deleteAll(): void
    {
        $this->connection->exec('DELETE FROM sessions');
    }
}