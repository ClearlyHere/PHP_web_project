<?php

    namespace App\Covoiturage\Lib;

    use App\Covoiturage\Model\HTTP\Session;
    use App\Covoiturage\Model\Repository\UtilisateurRepository;

    class ConnexionUtilisateur
    {
        private static string $cleConnexion = '_utilisateurConnecte';

        public static function connecter(string $loginUtilisateur): void
        {
            $session = Session::getInstance();
            $session->enregistrer(self::$cleConnexion, $loginUtilisateur);
        }

        public static function estConnecte(): bool
        {
            $session = Session::getInstance();
            return $session->contient(self::$cleConnexion);
        }

        public static function deconnecter(): void
        {
            $session = Session::getInstance();
            $session->supprimer(self::$cleConnexion);
        }

        public static function getLoginUtilisateurConnecte(): ?string
        {
            $session = Session::getInstance();
            if (self::estConnecte()) {
                return $session->lire(static::$cleConnexion);
            } else return null;
        }

        public static function estAdministrateur(): bool
        {
            if (ConnexionUtilisateur::estConnecte()) {
                $login = ConnexionUtilisateur::getLoginUtilisateurConnecte();
                $user = UtilisateurRepository::withLogin($login, true);
                if ($user->isEstAdmin()) {
                    return true;
                } else {
                    return false;
                }
            } else return false;
        }
    }