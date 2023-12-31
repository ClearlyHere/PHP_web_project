<?php

    namespace App\Covoiturage\Controller;

    use App\Covoiturage\Config\ExceptionHandling;
    use App\Covoiturage\Lib\MessageFlash;
    use App\Covoiturage\Model\HTTP\Session;
    use Exception;
    use App\Covoiturage\Lib\PreferenceController;

    class ControllerGeneric
    {
        public function error(Exception $e): void
        {
            $this->afficheVue("Erreur", "/../error.php",
                ["exception" => $e]);
        }

        protected function getBodyFolder(): string
        {
            return '/generic';
        }

        public function GetURLIdentifier(): string
        {
            return "id";
        }

        protected function afficheVue(string $pagetitle, string $cheminVueBody, array $parametres = []): void
        {
            $parametres += ['pagetitle' => $pagetitle, 'cheminVueBody' => $this->getBodyFolder() . $cheminVueBody];
            extract($parametres); // Crée des variables à partir du tableau $parametres
            require(__DIR__ . '/../View/view.php'); // Charge la vue
        }

        public function formulairePreference(): void
        {
            Session::getInstance();
            $this->afficheVue("Préférence contrôlleur", "/../formulairePreference.php");
        }

        public function enregistrerPreference(): void
        {
            if (isset($_GET['controleur_defaut'])) {
                PreferenceController::enregistrer($_GET['controleur_defaut']);
            }
            MessageFlash::ajouter("success", "Vous avez enregistré "
                . $_GET['controleur_defaut'] . " comme votre préférence!");
            $this->afficheVue("Préférence enregistré",
                "/../formulairePreference.php");
        }
    }