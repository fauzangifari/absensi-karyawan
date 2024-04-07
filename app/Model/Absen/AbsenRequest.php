<?php

namespace App\Model\Absen;

class AbsenRequest
{
    public ?string $id_absen = null;
    public ?string $username_karyawan = null;
    public ?string $nama_karyawan = null;
    public ?string $tanggal_absen = null;
    public ?string $jam_masuk = null;
    public ?string $jam_keluar = null;
    public ?string $keterangan = null;
    public ?string $alasan = null;
    public ?string $file = null;
}