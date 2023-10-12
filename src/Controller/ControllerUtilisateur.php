<?php

    namespace App\Covoiturage\Controller;

    use App\Covoiturage\Config\ExceptionHandling;
    use App\Covoiturage\Lib\MessageFlash;
    use App\Covoiturage\Model\HTTP\Cookie;
    use App\Covoiturage\Model\Repository\UtilisateurRepository;
    use Exception;

    class ControllerUtilisateur extends ControllerGeneric
    {
        private static string $utilisteurClass = 'App\Covoiturage\Model\DataObject\Utilisateur';


        protected function getBodyFolder(): string
        {
            return '/utilisateur';
        }

        public function GetURLIdentifier(): string
        {
            return "login";
        }

        public static function readAll(): void
        {
            $utilisateurs = (new UtilisateurRepository())->selectAll(); // Appel au modèle pour gérer
            (new ControllerUtilisateur())->afficheVue('Liste de Utilisateurs', '/list.php',
                ["utilisateurs" => $utilisateurs]);
        }

        public static function readOne($login): void
        {
            try {
                $retour = (new UtilisateurRepository())->select($login);
                ExceptionHandling::checkInstanceClass($retour, static::$utilisteurClass, 107);
                (new ControllerUtilisateur())->afficheVue('Utilisateur', '/detail.php',
                    ["utilisateur" => $retour]);
            } catch (Exception $e) {
                (new ControllerUtilisateur())->error($e);
            }
        }

        public static function update($login)
        {
            $utilisateur = (new UtilisateurRepository())->select($login);
            (new ControllerUtilisateur())->afficheVue("Update utilisateur", "/update.php",
                ["utilisateur" => $utilisateur]);
        }

        public static function updated(): void
        {
            try {
                $new_utilisateur = (new UtilisateurRepository())->Construire($_GET);
                $oldLogin = $_GET['oldLogin'];

                $retour = (new UtilisateurRepository())->mettreAJour($new_utilisateur, $oldLogin);
                ExceptionHandling::checkTrueValue($retour, 106);
                $utilisateurs = (new UtilisateurRepository())->selectAll();
                MessageFlash::ajouter("success", "L'utilisateur' " . $new_utilisateur->getPrimaryKeyValue(). " a bien été mise à jour!" );
                (new ControllerUtilisateur())->afficheVue("Update utilisateur", "/list.php",
                    ["login" => $new_utilisateur->getPrimaryKeyValue(), "utilisateurs" => $utilisateurs]);
            } catch (Exception $e) {
                MessageFlash::ajouter("danger", "L'utilisateur " . $new_utilisateur->getPrimaryKeyValue(). " n'a pas été mise à jour" );

                (new ControllerUtilisateur())->error($e);
            }
        }

        public static function create(): void
        {
            (new ControllerUtilisateur())->afficheVue("Créer utilisateur", "/create.php");
        }

        public static function created(): void
        {
            try {
                $nouvel_utilisateur = (new UtilisateurRepository())->Construire($_GET);
                $retour = (new UtilisateurRepository())->Sauvegarder($nouvel_utilisateur);
                ExceptionHandling::checkTrueValue(is_bool($retour), 106);
                $utilisateurs = (new UtilisateurRepository())->selectAll();
                MessageFlash::ajouter("success", "L'utilisateur " . $nouvel_utilisateur->getPrimaryKeyValue() . " a bien été créé!");

                (new ControllerUtilisateur())->afficheVue("Créer utilisateur", "/list.php",
                    ['utilisateurs' => $utilisateurs, 'login' => $nouvel_utilisateur->getPrimaryKeyValue()]);
            } catch (Exception $e) {
                MessageFlash::ajouter("danger", "L'utilisateur n'a pas pu être créé");
                (new ControllerUtilisateur())->error($e);
            }
        }

        public static function delete(string $login): void
        {
            try {
                $bool = (new UtilisateurRepository())->effacer($login);
                ExceptionHandling::checkTrueValue(is_bool($bool), 106);
                $utilisateurs = (new UtilisateurRepository())->selectAll();
                MessageFlash::ajouter("success", "L'utilisateur " . $login . " a bien été éffacée!" );

                (new ControllerUtilisateur())->afficheVue("Utilisateur éffacé", "/list.php",
                    ["utilisateurs" => $utilisateurs, "login" => $login]);
            } catch (Exception $e) {
                MessageFlash::ajouter("danger", "L'utilisateur " . $login . " n'a pas été éffacé" );

                (new ControllerUtilisateur())->error($e);
            }
        }
    }

//        public static function deposerCookie() : void
//        {
//            Cookie::enregistrer('COOKIE1', 1, 3600);
//            Cookie::enregistrer('COOKIE2', 2, 3600);
//            $utilisateurs = (new UtilisateurRepository())->selectAll(); // Appel au modèle pour gérer
//            (new ControllerUtilisateur())->afficheVue('Liste de Utilisateurs', '/list.php',
//                ["utilisateurs" => $utilisateurs]);
//        }
//
//        public static function lireCookie() : void
//        {
//            $cookies = [Cookie::lire('COOKIE1'),Cookie::lire('COOKIE2')];
//            $utilisateurs = (new UtilisateurRepository())->selectAll(); // Appel au modèle pour gérer
//            (new ControllerUtilisateur())->afficheVue('Liste de Utilisateurs', '/list.php',
//                ["utilisateurs" => $utilisateurs, "cookies" => $cookies]);
//        }
//
//        public static function supprimerCookie() : void
//        {
//            Cookie::effacerCookie('COOKIE1');
//            Cookie::effacerCookie('COOKIE2');
//            $utilisateurs = (new UtilisateurRepository())->selectAll(); // Appel au modèle pour gérer
//            (new ControllerUtilisateur())->afficheVue('Liste de Utilisateurs', '/list.php',
//                ["utilisateurs" => $utilisateurs]);
//        }
//    }