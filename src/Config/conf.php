<?php
    namespace App\Covoiturage\Config;
    // Class configuration pour se connecter à la BDD
    class Conf
    {
        public static int $dureeSession = 300;
        // Attribut array $databases contenant les informations login à la BDD
        static private array $databases = array(
            'hostname' => 'localhost',
            'database' => 'lionscale',
            'login' => 'root',
            'password' => ''
        );

        // Fonctions getters statiques pour obtenirs les informations
        static public function getHostname(): string
        {
            return static::$databases['hostname'];
        }

        static public function getDatabase(): string
        {
            return static::$databases['database'];
        }

        static public function getLogin(): string
        {
            return static::$databases['login'];
        }

        static public function getPassword(): string
        {
            return static::$databases['password'];
        }
    }
