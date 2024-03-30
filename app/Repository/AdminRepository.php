<?php

namespace App\Repository;

use App\Domain\Admin;

class AdminRepository
{
    private  \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function saveAdmin(Admin $admin) : Admin
    {
        $statement = $this->connection->prepare('INSERT INTO admin (username, password, nama_admin) VALUES (?, ?, ?)');
        $statement->execute([
            $admin->username,
            $admin->password,
            $admin->nama_admin
        ]);
        return $admin;
    }

    public function findByUsername(string $username): ?Admin
    {
        $statement = $this->connection->prepare("SELECT username, password, nama_admin FROM admin WHERE username = ?");
        $statement->execute([$username]);

        try {
            if (($row = $statement->fetch()) !== false) {
                $admin = new Admin();
                $admin->username = $row['username'];
                $admin->password = $row['password'];
                $admin->nama_admin = $row['nama_admin'];
                return $admin;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteAll() : void
    {
        $this->connection->exec("DELETE FROM admin");
    }
}