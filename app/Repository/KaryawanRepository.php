<?php

namespace App\Repository;

use App\Domain\Karyawan;

class KaryawanRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function saveKaryawan(Karyawan $karyawan) : Karyawan
    {
        $statement = $this->connection->prepare('INSERT INTO karyawan (username, password, nama_karyawan, alamat_karyawan, no_telp_karyawan) VALUES (?, ?, ?, ?, ?)');
        $statement->execute([
            $karyawan->username,
            $karyawan->password,
            $karyawan->nama_karyawan,
            $karyawan->alamat_karyawan,
            $karyawan->no_telp_karyawan
        ]);
        return $karyawan;
    }

    public function findByUsername(string $username): ?Karyawan
    {
            $statement = $this->connection->prepare("SELECT username, password, nama_karyawan, alamat_karyawan, no_telp_karyawan FROM karyawan WHERE username = ?");
            $statement->execute([$username]);

        try {
            if (($row = $statement->fetch()) !== false) {
                $karyawan = new Karyawan();
                $karyawan->username = $row['username'];
                $karyawan->password = $row['password'];
                $karyawan->nama_karyawan = $row['nama_karyawan'];
                $karyawan->alamat_karyawan = $row['alamat_karyawan'];
                $karyawan->no_telp_karyawan = $row['no_telp_karyawan'];
                return $karyawan;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function countKaryawan(): int
    {
        $statement = $this->connection->prepare("SELECT COUNT(*) FROM karyawan");
        $statement->execute();
        $result = $statement->fetchColumn();
        return (int) $result;
    }

    public function showAllKaryawan(): array
    {
        $statement = $this->connection->prepare("SELECT username, nama_karyawan, alamat_karyawan, no_telp_karyawan FROM karyawan");
        $statement->execute();

        $karyawanList = [];

        try {
            while (($row = $statement->fetch()) !== false) {
                $karyawan = new Karyawan();
                $karyawan->username = $row['username'];
                $karyawan->nama_karyawan = $row['nama_karyawan'];
                $karyawan->alamat_karyawan = $row['alamat_karyawan'];
                $karyawan->no_telp_karyawan = $row['no_telp_karyawan'];
                $karyawanList[] = $karyawan;
            }
        } finally {
            $statement->closeCursor();
        }

        return $karyawanList;
    }

    public function deleteKaryawan(string $username): void
    {
        $statement = $this->connection->prepare("DELETE FROM karyawan WHERE username = ?");
        $statement->execute([$username]);
    }

    public function updateKaryawan(Karyawan $karyawan): void
    {
        $statement = $this->connection->prepare("UPDATE karyawan SET nama_karyawan = ?, alamat_karyawan = ?, no_telp_karyawan = ? WHERE username = ?");
        $statement->execute([
            $karyawan->nama_karyawan,
            $karyawan->alamat_karyawan,
            $karyawan->no_telp_karyawan,
            $karyawan->username
        ]);
    }

    public function deleteAll() : void
    {
        $this->connection->exec("DELETE FROM karyawan");
    }
}