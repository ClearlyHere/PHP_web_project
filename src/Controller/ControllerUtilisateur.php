<?php

    namespace App\Covoiturage\Controller;

    use App\Covoiturage\Config\ExceptionHandling;
    use App\Covoiturage\Lib\ConnexionUtilisateur;
    use App\Covoiturage\Lib\MessageFlash;
    use App\Covoiturage\Lib\MotDePasse;
    use App\Covoiturage\Model\DataObject\Utilisateur;
    use App\Covoiturage\Model\Repository\UtilisateurRepository;
    use Exception;

    class ControllerUtilisateur extends ControllerGeneric
    {
        private static string $utilisateurClass = 'App\Covoiturage\Model\DataObject\Utilisateur';


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
                ExceptionHandling::checkInstanceClass($retour, static::$utilisateurClass, 107);
                (new ControllerUtilisateur())->afficheVue('Utilisateur', '/detail.php',
                    ["utilisateur" => $retour]);
            } catch (Exception $e) {
                if ($e->getCode() == 107) {
                    MessageFlash::ajouter("warning", "Cet utilisateur n'existe pas");
                    header("Location: index.php?controller=utilisateur");
                } else {
                    MessageFlash::ajouter("danger", "Erreur durant la lecture de l'utilisateur");
                    (new ControllerUtilisateur())->error($e);
                }
            }
        }

        public static function update($login): void
        {
            try {
                ExceptionHandling::checkTrueValue($login === ConnexionUtilisateur::getLoginUtilisateurConnecte(),
                    116);
                $utilisateur = (new UtilisateurRepository())->select($login);
                (new ControllerUtilisateur())->afficheVue("Update utilisateur", "/update.php",
                    ["utilisateur" => $utilisateur]);
            } catch (Exception $e) {
                if ($e->getCode() === 116) {
                    MessageFlash::ajouter('warning', "Vous n'avez pas les droits d'accéder à cette page");
                } else {
                    MessageFlash::ajouter('danger', "Une erreur en accédant à la mise à jour de " . $login);
                }
                header("Location: index.php?controller=utilisateur");
            }
        }

        public static function updated(): void
        {
            try {
                $oldLogin = $_GET['oldLogin'];
                ExceptionHandling::checkTrueValue($oldLogin === ConnexionUtilisateur::getLoginUtilisateurConnecte()
                ,116);
                // Création de l'ancien utilisateur à partir du login
                $utilisateur = UtilisateurRepository::withLogin($oldLogin, true);
                // On vérifie que celui-ci existe dans la base de données
                ExceptionHandling::checkTrueValue($utilisateur instanceof Utilisateur, 113);

                // On obtient son mot de pass haché
                $old_mdp = $utilisateur->getMdpHache();
                // On créé un nouvel utilisateur avec les nouvelles données
                if (!ConnexionUtilisateur::estAdministrateur()) $_GET['estAdmin'] = null;
                // On vérifier que les mots de passes saisies sont égaux
                ExceptionHandling::checkTrueValue($_GET['mdpHache'] === $_GET['mdpHacheVerif'], 111);
                // On vérifie que le mot de passe ancien est correct
                ExceptionHandling::checkTrueValue(MotDePasse::verifier($_GET['ancienMdpClair'], $old_mdp), 112);

                $login = $_GET['login'] ?? null;
                $prenom = $_GET['nom'] ?? null;
                $nom = $_GET['prenom'] ?? null;
                $mdp = $_GET['mdpHache'] ?? null;
                if (!is_null($login) && $login != '') $utilisateur->SetLogin($login);
                if (!is_null($prenom) && $prenom != '') $utilisateur->SetPrenom($prenom);
                if (!is_null($nom) && $nom != '') $utilisateur->SetNom($nom);
                if (!is_null($mdp) && $mdp != '') $utilisateur->setMdpHache($mdp);

                // On sauvegarde les nouvelles données sur l'utilisateur
                $retour = (new UtilisateurRepository())->mettreAJour($utilisateur, $oldLogin);
                // On vérifie que la sauvegarde s'est bien passée
                ExceptionHandling::checkTrueValue($retour, 106);

                $newLogin = $_GET['login'];
                if ($newLogin != $oldLogin
                    && $oldLogin == ConnexionUtilisateur::getLoginUtilisateurConnecte()
                    && $newLogin != '')
                {
                    ConnexionUtilisateur::deconnecter();
                    ConnexionUtilisateur::connecter($newLogin);
                }

                MessageFlash::ajouter("success", "L'utilisateur " . $utilisateur->getPrimaryKeyValue() . " a bien été mise à jour!");
                header("Location: index.php?controller=utilisateur");
            } catch (Exception $e) {
                if ($e->getCode() === 116) {
                    MessageFlash::ajouter('warning', "Vous n'avez pas les droits d'accéder à cette page");
                    header("Location: index.php?controller=utilisateur");
                } else if ($e->getCode() === 112) {
                    MessageFlash::ajouter("warning", "L'ancien mot de passe que vous avez saisi est érronée");
                    self::update($oldLogin);
                } else if ($e->getCode() === 111) {
                    MessageFlash::ajouter("warning", "Vérifiez que votre mot de passe soit correcte sur les 2 champs");
                    self::update($oldLogin);
                } else {
                    MessageFlash::ajouter("danger", "L'utilisateur " . $utilisateur->getPrimaryKeyValue() . " n'a pas été mise à jour");
                    (new ControllerUtilisateur())->error($e);
                }
            }
        }

        public static function updateAdmin($login): void
        {
            try {
                ExceptionHandling::checkTrueValue($login === ConnexionUtilisateur::getLoginUtilisateurConnecte()
                    || ConnexionUtilisateur::estAdministrateur(), 116);
                $utilisateur = (new UtilisateurRepository())->select($login);
                (new ControllerUtilisateur())->afficheVue("Update utilisateur", "/updateAdmin.php",
                    ["utilisateur" => $utilisateur]);
            } catch (Exception $e) {
                if ($e->getCode() === 116) {
                    MessageFlash::ajouter('warning', "Vous n'avez pas les droits d'accéder à cette page");
                } else {
                    MessageFlash::ajouter('danger', "Une erreur en accédant à la mise à jour de " . $login);
                }
                header("Location: index.php?controller=utilisateur");
            }
        }

        public static function updatedAdmin(): void
        {
            try {
                $oldLogin = $_GET['oldLogin'];
                ExceptionHandling::checkTrueValue($oldLogin === ConnexionUtilisateur::getLoginUtilisateurConnecte()
                    || ConnexionUtilisateur::estAdministrateur(), 116);

                // Création de l'ancien utilisateur à partir du login
                $utilisateur = UtilisateurRepository::withLogin($oldLogin, true);
                // On vérifie que celui-ci existe dans la base de données
                ExceptionHandling::checkTrueValue($utilisateur instanceof Utilisateur, 113);

                if (!ConnexionUtilisateur::estAdministrateur()) $_GET['estAdmin'] = null;

                // On modifie les données de l'utilisateur
                $login = $_GET['login'] ?? null;
                $prenom = $_GET['prenom'] ?? null;
                $nom = $_GET['nom'] ?? null;
                if (!is_null($login) && $login != '') $utilisateur->SetLogin($login);
                if (!is_null($prenom) && $prenom != '') $utilisateur->SetPrenom($prenom);
                if (!is_null($nom) && $nom != '') $utilisateur->SetNom($nom);
                // On sauvegarde les nouvelles données sur l'utilisateur
                $retour = (new UtilisateurRepository())->mettreAJour($utilisateur, $oldLogin);
                // On vérifie que la sauvegarde s'est bien passée
                ExceptionHandling::checkTrueValue($retour, 106);

                if ($login != $oldLogin && $oldLogin == ConnexionUtilisateur::getLoginUtilisateurConnecte()) {
                    ConnexionUtilisateur::deconnecter();
                    ConnexionUtilisateur::connecter($login);
                }

                MessageFlash::ajouter("success", "L'utilisateur " . $utilisateur->getPrimaryKeyValue() . " a bien été mise à jour!");
                header("Location: index.php?controller=utilisateur");
            } catch (Exception $e) {
                if ($e->getCode() === 116) {
                    MessageFlash::ajouter('warning', "Vous n'avez pas les droits d'accéder à cette page");
                    header("Location: index.php?controller=utilisateur");
                } else if ($e->getCode() === 112) {
                    MessageFlash::ajouter("warning", "L'ancien mot de passe que vous avez saisi est érronée");
                    self::update($oldLogin);
                } else if ($e->getCode() === 111) {
                    MessageFlash::ajouter("warning", "Vérifiez que votre mot de passe soit correcte sur les 2 champs");
                    self::update($oldLogin);
                } else {
                    MessageFlash::ajouter("danger", "L'utilisateur " . $utilisateur->getPrimaryKeyValue() . " n'a pas été mise à jour");
                    (new ControllerUtilisateur())->error($e);
                }
            }
        }

        public static function create(): void
        {
            (new ControllerUtilisateur())->afficheVue("Créer utilisateur", "/create.php");
        }

        public static function created(): void
        {
            try {
                ExceptionHandling::checkTrueValue($_GET['mdpHache'] === $_GET['mdpHacheVerif'], 111);
                if (!ConnexionUtilisateur::estAdministrateur()) $_GET['estAdmin'] = null;
                $nouvel_utilisateur = (new UtilisateurRepository())->construireDepuisFormulaire($_GET);
                $retour = (new UtilisateurRepository())->Sauvegarder($nouvel_utilisateur);
                ExceptionHandling::checkTrueValue(is_bool($retour), 106);
                MessageFlash::ajouter("success", "L'utilisateur "
                    . $nouvel_utilisateur->getPrimaryKeyValue() . " a bien été créé!");
                if (!ConnexionUtilisateur::estConnecte()) {
                    ConnexionUtilisateur::connecter($nouvel_utilisateur->getPrimaryKeyValue());
                }
                header("Location: index.php?controller=utilisateur");
            } catch (Exception $e) {
                if ($e->getCode() === 111) {
                    MessageFlash::ajouter("warning", "Vérifiez que votre mot de passe soit correcte sur les 2 champs");
                    self::create();
                } else {
                    MessageFlash::ajouter("danger", "L'utilisateur n'a pas pu être créé");
                    (new ControllerUtilisateur())->error($e);
                }
            }
        }

        public static function delete(string $login): void
        {
            try {
                ExceptionHandling::checkTrueValue($login === ConnexionUtilisateur::getLoginUtilisateurConnecte()
                    || ConnexionUtilisateur::estAdministrateur(), 116);
                $bool = (new UtilisateurRepository())->effacer($login);
                ExceptionHandling::checkTrueValue(is_bool($bool), 106);
                if (ConnexionUtilisateur::getLoginUtilisateurConnecte() === $login) {
                    ConnexionUtilisateur::deconnecter();
                }
                MessageFlash::ajouter("success", "L'utilisateur " . $login . " a bien été éffacée!");
                header("Location: index.php?controller=utilisateur");
            } catch (Exception $e) {
                if ($e->getCode() === 116) {
                    MessageFlash::ajouter('warning', "Vous n'avez pas les droits d'accéder à cette page");
                    header("Location: index.php?controller=utilisateur");
                } else {
                    MessageFlash::ajouter("danger", "L'utilisateur " . $login . " n'a pas été éffacé");
                    (new ControllerUtilisateur())->error($e);
                }
            }
        }

        public static function connexion(): void
        {
            (new ControllerUtilisateur())->afficheVue("Connexion utilisateur", "/connexion.php");
        }

        public static function connected(): void
        {
            try {
                $user = (new UtilisateurRepository())->select($_GET['login']);
                $mdpClair = $_GET['mdpClair'];
                ExceptionHandling::checkTrueValue($user instanceof Utilisateur, 113);
                ExceptionHandling::checkTrueValue(MotDePasse::verifier($mdpClair, $user->getMdpHache()), 114);
                ConnexionUtilisateur::connecter($user->getPrimaryKeyValue());
                MessageFlash::ajouter("success", "Bienvenue, " . $user->getPrimaryKeyValue() . '!');
                header("Location: index.php?controller=utilisateur");
            } catch (Exception $e) {
                if ($e->getCode() === 113) {
                    MessageFlash::ajouter("warning", "Cet utilisateur n'existe pas");
                    self::connexion();
                } else if ($e->getCode() === 114) {
                    MessageFlash::ajouter("warning", "Vérifiez votre mot de passe");
                    self::connexion();
                } else {
                    MessageFlash::ajouter("danger", "Erreur durant la connexion, veuillez réessayer");
                    (new ControllerUtilisateur())->error($e);
                }
            }
        }

        public static function logout(): void
        {
            try {
                ExceptionHandling::checkTrueValue(ConnexionUtilisateur::estConnecte(), 115);
                MessageFlash::ajouter("info", 'Vous vous êtes déconnecté.');
                ConnexionUtilisateur::deconnecter();
                header("Location: index.php?controller=utilisateur");
            } catch (Exception $e) {
                if ($e->getCode() === 115) {
                    MessageFlash::ajouter('warning', "Vous n'êtes plus connecté");
                } else {
                    MessageFlash::ajouter('danger', "Erreur durant la déconnexion");
                }
                header("Location: index.php?controller=utilisateur");
            }
        }
    }