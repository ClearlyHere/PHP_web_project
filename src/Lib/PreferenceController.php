<?php

    namespace App\Covoiturage\Lib;
    use App\Covoiturage\Model\HTTP\Cookie;

    class PreferenceController
    {
        private static string $clePreference = 'controleur_defaut';
        public static function enregistrer(string $preference) : void
        {
            Cookie::enregistrer(static::$clePreference, $preference);
        }
        public static function lire() : string
        {
            return Cookie::lire(static::$clePreference);
        }
        public static function existe() : bool
        {
            return Cookie::contient(static::$clePreference);
        }
        public static function supprimer() : void
        {
            Cookie::effacerCookie(static::$clePreference);
        }

        public static function checkRadio(string $controller) : void {
            if (isset($_GET['controleur_defaut']))
            {
                if ($_GET['controleur_defaut'] == $controller) {
                    echo "checked";
                }
            }
            else if (PreferenceController::existe())
            {
                if (PreferenceController::lire() == $controller)
                {
                    echo "checked";
                }
            }
        }
    }