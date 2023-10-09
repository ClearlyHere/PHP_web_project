<?php

    namespace App\Covoiturage\Model\HTTP;
    use Exception;
    class Session
    {
        private static ?Session $instance = null;

        private function __construct()
        {
            if (session_start() === false)
            {
                throw new Exception("La session n'a pas réussi à démarer");
            }
        }

        public function enregistrer(string $cle, mixed $valeur) : void
        {
            $_SESSION[$cle] = $valeur;
        }

        public function lire(string $cle) : mixed
        {
            return $_SESSION[$cle];
        }

        public function supprimer(string $cle) : void
        {
            unset($_SESSION[$cle]);
        }

        public static function getInstance() : Session
        {
            if (is_null(static::$instance))
            {
                static::$instance = new Session();
            }
            return static::$instance;
        }

        public static function detruire() : void
        {
            session_unset();
            session_destroy();
            Cookie::effacerCookie(session_name());
            $instance = null;
        }
    }