<?php

    namespace App\Covoiturage\Config;

    use Exception;

    class ExceptionHandling
    {
        protected static array $errorMessages = [
            101 => "L'immatriculation doit faire 8 caractères",
            102 => "Le nombre de sièges est trop grand",
            103 => "La couleur est trop longue",
            104 => "La marque est trop longue",
            105 => "L'immatriculation n'est pas indiquée",
            106 => "Erreur durant la mise à jour sur la base de données",
            107 => "Instance de données incompatibles",
            108 => "Immaticulation inexistante",
            109 => "Ce controller n'existe pas",
            110 => "Cette action n'existe pas",
            111 => "Les mots de passes ne coincident pas",
            112 => "Ancien mot de passe érronée",
            113 => "Utilisateur inexistant",
            114 => "Mot de passe incorrecte",
            115 => "Il semble que vous n'étiez plus connecté en session",
            116 => "Pas la permission nécessaire pour accéder à cette page",
            403 => "Vous n'avez pas les permissions pour accéder à ce fichier",
            404 => "Le fichier ou l'URL que vous avez saisi semble être indisponible",
            500 => "Nous avons retrouvé une erreur avec le serveur, veuillez réessayer ultérieurement.",
        ];

        private static function throwException($errorCode): void
        {
            throw new Exception('Erreur ' . $errorCode . ': ', $errorCode);
        }

        public static function triggerException($errorCode): Exception
        {
            return new Exception('Erreur ' . $errorCode . ': ', $errorCode);
        }

        public static function getErrorMessage(int $errorCode): string
        {
            return self::$errorMessages[$errorCode] ?? 'Erreur inconnue';
        }

        // INVALID ARGUMENT EXCEPTIONS HANDLING DANS LES 100
        public static function checkValueOverLimit($value, int $limit, int $errorCode): void
        {
            if ($value > $limit)
                self::throwException($errorCode);
        }

        public static function checkValueEquality(mixed $value1, mixed $value2, int $errorCode): void
        {
            if ($value1 !== $value2)
                self::throwException($errorCode);
        }

        public static function checkInstanceClass(mixed $instance, string $instanceClassName, int $errorCode): void
        {
            if (!$instance instanceof $instanceClassName) {
                self::throwException($errorCode);
            }
        }


        public static function checkTrueValue(mixed $value, int $errorCode): void
        {
            if (!$value) {
                self::throwException($errorCode);
            }
        }

    }