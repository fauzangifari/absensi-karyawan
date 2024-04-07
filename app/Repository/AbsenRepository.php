<?php

namespace App\Repository;

use App\Domain\Absen;

class AbsenRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function saveAbsen(Absen $absen): Absen
    {
        $statement = $this->connection->prepare('INSERT INTO absen (id_absen, username_karyawan, nama_karyawan, tanggal_absen, jam_masuk, jam_keluar, keterangan, alasan, file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $statement->execute([
            $absen->id_absen,
            $absen->username_karyawan,
            $absen->nama_karyawan,
            $absen->tanggal_absen,
            $absen->jam_masuk,
            $absen->jam_keluar,
            $absen->keterangan,
            $absen->alasan,
            $absen->file
        ]);
        return $absen;
    }

    public function checkEmployeeAbsen(string $username_karyawan, string $tanggal_absen): ?Absen
    {
        $statement = $this->connection->prepare('SELECT * FROM absen WHERE username_karyawan = ? AND tanggal_absen = ?');
        $statement->execute([$username_karyawan, $tanggal_absen]);

        try {
            if (($row = $statement->fetch()) !== false) {
                $absen = new Absen();
                $absen->id_absen = $row['id_absen'];
                $absen->username_karyawan = $row['username_karyawan'];
                $absen->nama_karyawan = $row['nama_karyawan'];
                $absen->tanggal_absen = $row['tanggal_absen'];
                $absen->jam_masuk = $row['jam_masuk'];
                $absen->jam_keluar = $row['jam_keluar'];
                $absen->keterangan = $row['keterangan'];
                $absen->alasan = $row['alasan'];
                $absen->file = $row['file'];
                return $absen;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function showAllAttedance(): array
    {
        $statement = $this->connection->query('SELECT username_karyawan, nama_karyawan, tanggal_absen, jam_masuk, jam_keluar, keterangan, alasan FROM absen');
        $statement->execute();

        $result = [];

        try {
            while (($row = $statement->fetch()) !== false) {
                $absen = new Absen();
                $absen->username_karyawan = $row['username_karyawan'];
                $absen->nama_karyawan = $row['nama_karyawan'];
                $absen->tanggal_absen = $row['tanggal_absen'];
                $absen->jam_masuk = $row['jam_masuk'];
                $absen->jam_keluar = $row['jam_keluar'];
                $absen->keterangan = $row['keterangan'];
                $absen->alasan = $row['alasan'];
                $result[] = $absen;
            }
        } finally {
            $statement->closeCursor();
        }
        return $result;
    }


    public function deleteAll(): void
    {
        $this->connection->exec('DELETE FROM absen');
    }
}