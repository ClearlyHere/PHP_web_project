<?php

    namespace App\Covoiturage\Lib;

    use App\Covoiturage\Model\HTTP\Cookie;
    use App\Covoiturage\Model\HTTP\Session;

    class MessageFlash
    {
        private static string $cleFlash = "_messageFlash";

        public static function ajouter(string $type, string $message) : bool
        {
            if ($session = Session::getInstance()) {
                $messageData = array($type, $message);
                $cookieData = serialize($messageData);
                $session->enregistrer(static::$cleFlash, $cookieData);
                return true;
            }
            return false;
        }

        public static function contientMessage() : bool
        {
            $session = Session::getInstance();
            return $session->contient(static::$cleFlash);
        }

        public static function lireMessage() : string|bool
        {
            if ($session = Session::getInstance()){
                $cookieData = $session->lire(static::$cleFlash);
                $session->supprimer(static::$cleFlash);
                $messageArray = unserialize($cookieData);
                return self::conversionMessageHTML($messageArray);
            }
            return false;
        }

        private static function conversionMessageHTML(array $messageArray) : string
        {
            return '<div class="alert alert-'. $messageArray[0] . '" role="alert">' .
                '<strong>' . ucwords($messageArray[0]) . '!</strong> ' . $messageArray[1]
                . '</div>';
        }
    }