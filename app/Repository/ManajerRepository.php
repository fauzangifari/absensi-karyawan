<?php

namespace App\Repository;

use App\Domain\Manajer;

class ManajerRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }


    public function saveManajer(Manajer $manajer) : Manajer
    {
        $statement = $this->connection->prepare('INSERT INTO manajer (username, password, nama_manajer, alamat_manajer, no_telp_manajer) VALUES (?, ?, ?, ?, ?)');
        $statement->execute([
            $manajer->username,
            $manajer->password,
            $manajer->nama_manajer,
            $manajer->alamat_manajer,
            $manajer->no_telp_manajer
        ]);
        return $manajer;
    }

    public function findByUsername(string $username): ?Manajer
    {
        $statement = $this->connection->prepare("SELECt username, password, nama_manajer, alamat_manajer, no_telp_manajer FROM manajer WHERE username = ?");
        $statement->execute([$username]);
        try {
            if (($row = $statement->fetch()) !== false) {
                $manajer = new Manajer();
                $manajer->username = $row['username'];
                $manajer->password = $row['password'];
                $manajer->nama_manajer = $row['nama_manajer'];
                $manajer->alamat_manajer = $row['alamat_manajer'];
                $manajer->no_telp_manajer = $row['no_telp_manajer'];
                return $manajer;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function countManajer(): int
    {
        $statement = $this->connection->prepare("SELECT COUNT(*) FROM manajer");
        $statement->execute();
        $result = $statement->fetchColumn();
        return (int) $result;
    }

    public function showAllManajer(): array
    {
        $statement = $this->connection->prepare("SELECT username, password, nama_manajer, alamat_manajer, no_telp_manajer FROM manajer");
        $statement->execute();
        $manajerList = [];
        try {
            while (($row = $statement->fetch()) !== false) {
                $manajer = new Manajer();
                $manajer->username = $row['username'];
                $manajer->password = $row['password'];
                $manajer->nama_manajer = $row['nama_manajer'];
                $manajer->alamat_manajer = $row['alamat_manajer'];
                $manajer->no_telp_manajer = $row['no_telp_manajer'];
                $manajerList[] = $manajer;
            }
        } finally {
            $statement->closeCursor();
        }
        return $manajerList;
    }

    public function deleteManajer(string $username): void
    {
        $statement = $this->connection->prepare("DELETE FROM manajer WHERE username = ?");
        $statement->execute([$username]);
    }

    public function updateManajer(Manajer $manajer): void
    {
        $statement = $this->connection->prepare("UPDATE manajer SET password = ?, nama_manajer = ?, alamat_manajer = ?, no_telp_manajer = ? WHERE username = ?");
        $statement->execute([
            $manajer->password,
            $manajer->nama_manajer,
            $manajer->alamat_manajer,
            $manajer->no_telp_manajer,
            $manajer->username
        ]);
    }

    public function deleteAll() : void
    {
        $this->connection->exec("DELETE FROM manajer");
    }
}