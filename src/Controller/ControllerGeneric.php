<?php

    namespace App\Covoiturage\Controller;

    use App\Covoiturage\Config\ExceptionHandling;
    use App\Covoiturage\Lib\MessageFlash;
    use App\Covoiturage\Model\HTTP\Session;
    use Exception;
    use App\Covoiturage\Lib\PreferenceController;

    class ControllerGeneric
    {
        protected function afficheVue(string $pagetitle, string $cheminVueBody, array $parametres = []): void
        {
            $parametres += ['pagetitle' => $pagetitle, 'cheminVueBody' => $this->getBodyFolder() . $cheminVueBody];
            extract($parametres); // Crée des variables à partir du tableau $parametres
            require(__DIR__ . '/../View/view.php'); // Charge la vue
        }

        public function formulairePreference()
        {
            $session = Session::getInstance();
            (new ControllerGeneric)->afficheVue("Préférence contrôlleur", "/../formulairePreference.php");
        }

        public function enregistrerPreference()
        {
            if (isset($_GET['controleur_defaut'])) {
                PreferenceController::enregistrer($_GET['controleur_defaut']);
            }
            MessageFlash::ajouter("success", "Vous avez enregistré " . $_GET['controleur_defaut'] . " comme votre préférence!");
            (new ControllerGeneric)->afficheVue("Préférence enregistré", "/../formulairePreference.php");
        }

        public function error(Exception $e)
        {
            $errorCode = $e->getCode();
            $errorMessage = ExceptionHandling::getErrorMessage($errorCode);
            $this->afficheVue("Erreur", "/../error.php",
                ["errorMessage" => $errorMessage]);
        }

        protected function getBodyFolder(): string
        {
            return '/generic';
        }

        public function GetURLIdentifier(): string
        {
            return "id";
        }
    }