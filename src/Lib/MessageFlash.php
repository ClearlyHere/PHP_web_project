<?php

    namespace App\Covoiturage\Lib;

    use App\Covoiturage\Model\HTTP\Session;

    class MessageFlash
    {
        private static string $cleFlash = "_messageFlash";

        public static function ajouter(string $type, string $message) : void
        {
            if ($session = Session::getInstance()) {
                $messageData = array($type, $message);
                $cookieData = serialize($messageData);
                $session->enregistrer(static::$cleFlash, $cookieData);
            }
        }

        public static function contientMessage() : bool
        {
            $session = Session::getInstance();
            return $session->contient(static::$cleFlash);
        }

        public static function lireMessage() : string|bool
        {
            if ($session = Session::getInstance()){
                $cookieSession = $session->lire(static::$cleFlash);

                if (!(is_null($cookieSession))) {
                    $session->supprimer(static::$cleFlash);
                    $messageArray = unserialize($cookieSession);
                    return self::conversionMessageHTML($messageArray);
                }
                else return false;
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