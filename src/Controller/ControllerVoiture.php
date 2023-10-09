<?php

    namespace App\Covoiturage\Controller;

    use App\Covoiturage\Model\Repository\VoitureRepository;
    use App\Covoiturage\Config\ExceptionHandling;
    use Exception;

    class ControllerVoiture extends ControllerGeneric
    {
        private static string $voitureClass = 'App\Covoiturage\Model\DataObject\Voiture';


        protected function getBodyFolder(): string
        {
            return '/voiture';
        }

        public function GetURLIdentifier(): string
        {
            return "immat";
        }

        // Actions et routage
        public static function readAll(): void
        {
            $voitures = (new VoitureRepository())->selectAll(); // Appel au modèle pour gérer
            (new ControllerVoiture())->afficheVue('Liste de voitures', '/list.php',
                ["voitures" => $voitures]);
        }

        public static function readOne(string $immatriculation): void
        {
            try {
                $retour = (new VoitureRepository())->select($immatriculation);
                ExceptionHandling::checkInstanceClass($retour, static::$voitureClass, 107);
                (new ControllerVoiture())->afficheVue('Détails de voiture', '/detail.php',
                    ["voiture" => $retour]);
            } catch (Exception $e) {
                (new ControllerVoiture())->error($e);
            }
        }

        public static function create(): void
        {
            (new ControllerVoiture())->afficheVue("Création de voiture", "/create.php");
        }

        public static function created(): void
        {
            try {
                $nouvelle_voiture = (new VoitureRepository())->Construire($_GET);
                $retour = (new VoitureRepository())->Sauvegarder($nouvelle_voiture);
                ExceptionHandling::checkTrueValue(is_bool($retour), 106);
                $voitures = (new VoitureRepository())->selectAll();
                (new ControllerVoiture())->afficheVue("Voiture créé", "/created.php",
                    ["voitures" => $voitures, "immat" => $nouvelle_voiture->getPrimaryKeyValue()]);
            } catch (Exception $e) {
                (new ControllerVoiture())->error($e);
            }
        }

        public static function delete(string $immatriculation): void
        {
            try {
                $bool = (new VoitureRepository())->effacer($immatriculation);
                ExceptionHandling::checkTrueValue(is_bool($bool), 106);
                $voitures = (new VoitureRepository())->selectAll();
                (new ControllerVoiture())->afficheVue("Voiture éffacé", "/deleted.php",
                    ["voitures" => $voitures, "immat" => $immatriculation]);
            } catch (Exception $e) {
                (new ControllerVoiture())->error($e);
            }
        }

        public static function update(string $immat)
        {
            $voiture = (new VoitureRepository())->select($immat);

            (new ControllerVoiture())->afficheVue("Update voiture", "/update.php",
                ["voiture" => $voiture]);
        }

        public static function updated()
        {
            try {
                $nouvelle_voiture = (new VoitureRepository())->Construire($_GET);

                ExceptionHandling::checkValueEquality(strlen($nouvelle_voiture->getPrimaryKeyValue()), 8, 101);
                ExceptionHandling::checkValueOverLimit($nouvelle_voiture->getNbSieges(), 200, 102);
                ExceptionHandling::checkValueOverLimit(strlen($nouvelle_voiture->getMarque()), 100, 103);
                ExceptionHandling::checkValueOverLimit(strlen($nouvelle_voiture->getCouleur()), 100, 104);

                ExceptionHandling::checkTrueValue(isset($_GET['oldImmat']), 105);
                $oldImmat = $_GET['oldImmat'];

                $retour = (new VoitureRepository())->mettreAJour($nouvelle_voiture, $oldImmat);
                ExceptionHandling::checkTrueValue($retour, 106);

                $voitures = (new VoitureRepository())->selectAll();
                (new ControllerVoiture())->afficheVue("Update voiture", "/updated.php",
                    ["immat" => $nouvelle_voiture->getPrimaryKeyValue(), "voitures" => $voitures]);

            } catch (Exception $e) {
                (new ControllerVoiture())->error($e);
            }
        }
    }
