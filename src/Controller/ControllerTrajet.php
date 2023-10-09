<?php

    namespace App\Covoiturage\Controller;

    use App\Covoiturage\Config\ExceptionHandling;
    use App\Covoiturage\Model\Repository\TrajetRepository;
    use App\Covoiturage\Model\Repository\UtilisateurRepository;
    use Exception;

    class ControllerTrajet extends ControllerGeneric
    {
        private static string $trajetClass = 'App\Covoiturage\Model\DataObject\Trajet';

        public function GetURLIdentifier(): string
        {
            return 'id';
        }

        protected function getBodyFolder(): string
        {
            return '/trajet';
        }

        public static function readAll(): void
        {
            $trajets = (new TrajetRepository())->selectAll(); // Appel au modèle pour gérer
            (new ControllerTrajet())->afficheVue('Liste de Trajets', '/list.php',
                ["trajets" => $trajets]);
        }

        public static function readOne(string $id): void
        {
            try {
                $retour = (new TrajetRepository())->select($id);
                ExceptionHandling::checkInstanceClass($retour, static::$trajetClass, 107);
                (new ControllerTrajet())->afficheVue('Détails du trajet', '/detail.php',
                    ["trajet" => $retour]);
            } catch (Exception $e) {
                (new ControllerTrajet())->error($e);
            }
        }

        public static function create(): void
        {
            (new ControllerTrajet())->afficheVue("Création de trajet", "/create.php");
        }

        public static function created(): void
        {
            try {
                // Costruire une instance de Utilisateur à partir du login dans GET['conducteur']
                $conducteur = (new UtilisateurRepository())->Construire(UtilisateurRepository::withLogin($_GET['conducteur']));
                // Créer un nouvel array à partir de $_GET en ajoutant le conducteur
                $GET_Array = $_GET + ['conducteurLogin' => $conducteur->getPrimaryKeyValue(), ];
                // Construction du trajet à partir du nouvel array
                $nouveauTrajet = (new TrajetRepository())->Construire($GET_Array);
                $retour = (new TrajetRepository())->Sauvegarder($nouveauTrajet);
                ExceptionHandling::checkTrueValue(is_bool($retour), 106);
                $trajets = (new TrajetRepository())->selectAll();
                (new ControllerTrajet())->afficheVue("Trajet créé", "/created.php",
                    ['trajets' => $trajets, 'trajet' => $nouveauTrajet]);
            } catch (Exception $e) {
                (new ControllerTrajet())->error($e);
            }
        }

        public static function delete(int $id) : void
        {
            try {
                $bool = (new TrajetRepository())->effacer($id);
                ExceptionHandling::checkTrueValue(is_bool($bool), 106);
                $trajets = (new TrajetRepository())->selectAll(); // Appel au modèle pour gérer
                (new ControllerTrajet())->afficheVue('Liste de Trajets', '/deleted.php',
                    ["trajets" => $trajets, "id" => $id]);
            } catch (Exception $e) {
                (new ControllerTrajet())->error($e);
            }
        }

        public static function update(int $id) : void
        {
            $trajet = (new TrajetRepository())->select($id);
            (new ControllerTrajet())->afficheVue("Mise à jour de trajet", "/update.php",
                ['trajet' => $trajet]);
        }

        public static function updated() : void {
            try {
                // Costruire une instance de Utilisateur à partir du login dans GET['conducteur']
                $conducteur = (new UtilisateurRepository())->Construire(UtilisateurRepository::withLogin($_GET['conducteur']));
                // Créer un nouvel array à partir de $_GET en ajoutant le conducteur
                $GET_Array = $_GET + ['conducteurLogin' => $conducteur->getPrimaryKeyValue(), ];
                // Construction du trajet à partir du nouvel array
                $nouveau_trajet = (new TrajetRepository())->Construire($GET_Array);
                $oldId = $_GET['oldId'];
                $retour = (new TrajetRepository())->mettreAJour($nouveau_trajet, $oldId);
                ExceptionHandling::checkTrueValue($retour, 106);
                $trajets = (new TrajetRepository())->selectAll(); // Appel au modèle pour gérer
                (new ControllerTrajet())->afficheVue('Liste de Trajets', '/updated.php',
                    ["trajets" => $trajets, "id" => $oldId]);
            } catch (Exception $e) {
                (new ControllerTrajet())->error($e);
            }
        }
    }