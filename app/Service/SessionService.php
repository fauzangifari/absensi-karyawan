<?php

namespace App\Service;

use App\Domain\Admin;
use App\Domain\Karyawan;
use App\Domain\Manajer;
use App\Domain\Session;
use App\Repository\AdminRepository;
use App\Repository\KaryawanRepository;
use App\Repository\ManajerRepository;
use App\Repository\SessionRepository;

class SessionService
{
    public static string $COOKIE_NAME = "FZN-SESSION";
    private SessionRepository $sessionRepository;
    private KaryawanRepository $karyawanRepository;
    private AdminRepository $adminRepository;
    private ManajerRepository $manajerRepository;
    public function __construct(SessionRepository $sessionRepository, KaryawanRepository $karyawanRepository, AdminRepository $adminRepository, ManajerRepository $manajerRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->karyawanRepository = $karyawanRepository;
        $this->adminRepository = $adminRepository;
        $this->manajerRepository = $manajerRepository;
    }

   public function createSession(string $username): Session
   {
        $session = new Session();
        $session->id_session = 'SSN_' . random_int(1000, 9999);
        $session->username = $username;

        $this->sessionRepository->saveSesion($session);

        setcookie(self::$COOKIE_NAME, $session->id_session, time() + (60 * 60 * 24 * 30), "/");
        return $session;
   }

   public function destroySession(): void
   {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';
        $this->sessionRepository->deleteById($sessionId);
       setcookie(self::$COOKIE_NAME, '', 1, "/");
   }

   public function currentSessionKaryawan(): ?Karyawan
   {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';

        $session = $this->sessionRepository->findById($sessionId);
        if ($session == null) {
            return null;
        }

        return $this->karyawanRepository->findByUsername($session->username);
   }

   public function currentSessionAdmin(): ?Admin
   {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';

        $session = $this->sessionRepository->findById($sessionId);
        if ($session == null) {
            return null;
        }

        return $this->adminRepository->findByUsername($session->username);
   }

   public function currentSessionManajer(): ?Manajer
   {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';

        $session = $this->sessionRepository->findById($sessionId);
        if ($session == null) {
            return null;
        }

        return $this->manajerRepository->findByUsername($session->username);
   }

}