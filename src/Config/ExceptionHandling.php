<?php

    namespace App\Covoiturage\Config;

    use App\Covoiturage\Model\DataObject\AbstractDataObject;
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
            110 => "Cette action n'existe pas"
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
            return "Erreur $errorCode : " . self::$errorMessages[$errorCode] ?? 'Erreur inconnue';
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

        public static function checkInstanceClass(mixed $instance, string $instanceClassName, int $errorCode) {
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