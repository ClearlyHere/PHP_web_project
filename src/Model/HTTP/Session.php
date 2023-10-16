<?php

    namespace App\Covoiturage\Model\HTTP;
    use App\Covoiturage\Config\Conf;
    use Exception;
    class Session
    {
        public static ?Session $instance = null;

        private function __construct()
        {
            session_set_cookie_params(Conf::$dureeSession);
            if (session_start() === false)
            {
                throw new Exception("La session n'a pas réussi à démarer");
            }
            $this->verifierDerniereActivite();
        }

        public function verifierDerniereActivite(): void
        {
            if (isset($_SESSION['derniereActivite']) && (time() - $_SESSION['derniereActivite'] > Conf::$dureeSession))
            {
                session_unset();
            }
            $_SESSION['derniereActivite'] = time();
        }

        public function contient(string $name): bool
        {
            return isset($_SESSION[$name]);
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
            if (isset($_SESSION[$cle])) {
                unset($_SESSION[$cle]);
            }
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
            static::$instance = null;
        }
    }