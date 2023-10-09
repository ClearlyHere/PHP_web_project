<?php

    namespace App\Covoiturage\Model\HTTP;

    class Cookie
    {
        public static function enregistrer(string $cle, mixed $valeur, ?int $dureeExpiration = null): void
        {
            $valeur = serialize($valeur);
            if (is_null($dureeExpiration)){
                setcookie($cle, $valeur, null);
            }
            else {
                setcookie($cle, $valeur, time() + $dureeExpiration);
            }
        }
        public static function lire(string $cle) : mixed
        {
            return unserialize($_COOKIE[$cle]) ?? null;
        }
        public static function contient(string $cle) : bool
        {
            if (isset($_COOKIE[$cle])){
                return true;
            }
            else return false;
        }
        public static function effacerCookie($cle) : void
        {
            if (isset($_COOKIE[$cle])){
                unset($_COOKIE[$cle]);
            }
        }
    }